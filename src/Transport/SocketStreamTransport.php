<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use JsonException;
use Misaf\DockerEngine\Configuration\TimeoutOptions;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\TransportException;

final readonly class SocketStreamTransport
{
    public function __construct(
        private string $endpoint,
        private Serializer $serializer,
        private TimeoutOptions $timeouts,
        private ?TlsOptions $tls,
    ) {}

    public function stream(Request $request): StreamResponse
    {
        [$address, $host, $context] = $this->connection();
        $errorCode = 0;
        $errorMessage = '';
        $socket = @stream_socket_client(
            $address,
            $errorCode,
            $errorMessage,
            $this->timeouts->connect,
            STREAM_CLIENT_CONNECT,
            $context,
        );

        if (false === $socket) {
            throw TransportException::connection($this->endpoint, $errorMessage . ' (' . $errorCode . ')');
        }

        $idleTimeout = $this->timeouts->streamIdle ?? $this->timeouts->request;
        stream_set_timeout($socket, (int) $idleTimeout, (int) (($idleTimeout - (int) $idleTimeout) * 1_000_000));
        $bodyStream = $request->body instanceof Stream ? $request->body : null;
        $body = null === $bodyStream ? $this->body($request) : null;
        $headers = ['Host' => $host, 'Connection' => 'close', ...$request->headers];

        if (null !== $bodyStream) {
            $headers += ['Content-Type' => 'application/octet-stream', 'Transfer-Encoding' => 'chunked'];
        } elseif (null !== $body) {
            $headers += ['Content-Type' => is_string($request->body) ? 'application/octet-stream' : 'application/json'];
            $headers['Content-Length'] = (string) mb_strlen($body, '8bit');
        } elseif (in_array(mb_strtoupper($request->method), ['POST', 'PUT', 'PATCH'], true)) {
            $headers['Content-Length'] = '0';
        }

        $head = mb_strtoupper($request->method) . ' ' . $request->target() . " HTTP/1.1\r\n";

        foreach ($headers as $name => $value) {
            $head .= $name . ': ' . $value . "\r\n";
        }

        $this->writeAll($socket, $head . "\r\n" . ($body ?? ''));

        if (null !== $bodyStream) {
            while (! $bodyStream->eof()) {
                $chunk = $bodyStream->read();

                if ('' !== $chunk) {
                    $this->writeAll($socket, dechex(mb_strlen($chunk, '8bit')) . "\r\n" . $chunk . "\r\n");
                }
            }

            $this->writeAll($socket, "0\r\n\r\n");
        }

        $statusLine = fgets($socket);

        if (false === $statusLine || 1 !== preg_match('/^HTTP\/\d(?:\.\d)?\s+(\d{3})/', mb_trim($statusLine), $matches)) {
            fclose($socket);

            throw TransportException::connection($this->endpoint, 'invalid HTTP status line');
        }

        $responseHeaders = [];

        while (false !== ($line = fgets($socket))) {
            if ("\r\n" === $line || "\n" === $line) {
                break;
            }

            $separator = mb_strpos($line, ':');

            if (false !== $separator) {
                $name = mb_trim(mb_substr($line, 0, $separator));
                $responseHeaders[$name][] = mb_trim(mb_substr($line, $separator + 1));
            }
        }

        $stream = new SocketStream($socket);

        if ($this->headerContains($responseHeaders, 'Upgrade', 'websocket')) {
            $this->assertWebSocketHandshake($request, $responseHeaders);
            $stream = new WebSocketStream($stream);
        } elseif ($this->headerContains($responseHeaders, 'Transfer-Encoding', 'chunked')) {
            $stream = new ChunkedStream($stream);
        }

        return new StreamResponse((int) $matches[1], $responseHeaders, $stream);
    }

    /** @return array{string, string, resource} */
    private function connection(): array
    {
        $contextOptions = [];

        if (str_starts_with($this->endpoint, 'unix://')) {
            return [$this->endpoint, 'docker', stream_context_create()];
        }

        $endpoint = str_starts_with($this->endpoint, 'tcp://')
            ? 'http://' . mb_substr($this->endpoint, 6)
            : $this->endpoint;
        $parts = parse_url($endpoint);
        $host = is_array($parts) && is_string($parts['host'] ?? null) ? $parts['host'] : null;
        $scheme = is_array($parts) && is_string($parts['scheme'] ?? null) ? $parts['scheme'] : 'http';

        if (null === $host) {
            throw TransportException::connection($this->endpoint, 'invalid HTTP endpoint');
        }

        $port = is_int($parts['port'] ?? null) ? $parts['port'] : ('https' === $scheme ? 443 : 80);

        if ('https' === $scheme) {
            $tls = $this->tls ?? new TlsOptions();
            $contextOptions['ssl'] = array_filter([
                'verify_peer'       => $tls->verifyPeer,
                'verify_peer_name'  => $tls->verifyHost,
                'peer_name'         => $host,
                'cafile'            => $tls->ca,
                'local_cert'        => $tls->certificate,
                'local_pk'          => $tls->privateKey,
                'passphrase'        => $tls->privateKeyPassword,
            ], static fn(mixed $value): bool => null !== $value);
        }

        return [('https' === $scheme ? 'tls' : 'tcp') . '://' . $host . ':' . $port, $host, stream_context_create($contextOptions)];
    }

    private function body(Request $request): ?string
    {
        if ($request->body instanceof Stream) {
            return null;
        }

        if (null === $request->body || is_string($request->body)) {
            return $request->body;
        }

        $value = is_object($request->body) ? $this->serializer->normalize($request->body) : $request->body;

        try {
            return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        } catch (JsonException $exception) {
            throw TransportException::connection($this->endpoint, 'request JSON encoding failed: ' . $exception->getMessage(), $exception);
        }
    }

    /** @param resource $socket */
    private function writeAll($socket, string $data): void
    {
        $offset = 0;

        while ($offset < mb_strlen($data, '8bit')) {
            $written = fwrite($socket, mb_substr($data, $offset, null, '8bit'));

            if (false === $written || 0 === $written) {
                fclose($socket);

                throw TransportException::connection($this->endpoint, 'socket write failed');
            }

            $offset += $written;
        }
    }

    /** @param array<string, list<string>> $headers */
    private function assertWebSocketHandshake(Request $request, array $headers): void
    {
        $key = $request->headers['Sec-WebSocket-Key'] ?? null;
        $accept = $this->headerValue($headers, 'Sec-WebSocket-Accept');

        if (null === $key || null === $accept
            || ! hash_equals(base64_encode(hash('sha1', $key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true)), $accept)) {
            throw new TransportException('Docker returned an invalid WebSocket handshake.');
        }
    }

    /** @param array<string, list<string>> $headers */
    private function headerValue(array $headers, string $name): ?string
    {
        foreach ($headers as $header => $values) {
            if (0 === strcasecmp($header, $name)) {
                return $values[0] ?? null;
            }
        }

        return null;
    }

    /** @param array<string, list<string>> $headers */
    private function headerContains(array $headers, string $name, string $needle): bool
    {
        foreach ($headers as $header => $values) {
            if (0 === strcasecmp($header, $name)) {
                return str_contains(mb_strtolower(implode(',', $values)), mb_strtolower($needle));
            }
        }

        return false;
    }
}
