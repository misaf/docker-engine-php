<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\Exceptions\ConnectionException;
use Misaf\DockerEngine\Exceptions\TimeoutException;
use Misaf\DockerEngine\Exceptions\TransportException;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\TimeoutExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class SymfonyTransport implements Transport
{
    private HttpClientInterface $client;

    private SocketStreamTransport $upgradedConnections;

    public function __construct(
        private ClientOptions $options,
        private Serializer $serializer,
        ?HttpClientInterface $client = null,
        ?SocketStreamTransport $upgradedConnections = null,
    ) {
        $this->client = $client ?? new CurlHttpClient();
        $this->upgradedConnections = $upgradedConnections ?? new SocketStreamTransport(
            $options->host,
            $serializer,
            $options->timeouts,
            $options->tls,
        );
    }

    public function request(Request $request): Response
    {
        try {
            $response = $this->client->request($this->method($request), $this->url($request), $this->requestOptions($request, false));

            return new Response(
                $response->getStatusCode(),
                $response->getHeaders(false),
                $response->getContent(false),
            );
        } catch (TimeoutExceptionInterface $exception) {
            throw new TimeoutException(sprintf('Docker request to %s timed out: %s', $this->options->host, $exception->getMessage()), previous: $exception);
        } catch (TransportExceptionInterface $exception) {
            throw new ConnectionException(sprintf('Docker transport to %s failed: %s', $this->options->host, $exception->getMessage()), previous: $exception);
        }
    }

    public function stream(Request $request): StreamResponse
    {
        if ($this->isUpgraded($request)) {
            return $this->upgradedConnections->stream($request);
        }

        try {
            $response = $this->client->request($this->method($request), $this->url($request), $this->requestOptions($request, true));
            $status = $response->getStatusCode();
            $headers = $response->getHeaders(false);
            $chunks = $this->client->stream($response, $request->streamIdleTimeout ?? $this->options->timeouts->streamIdle);

            return new StreamResponse(
                $status,
                $headers,
                new SymfonyResponseStream($response, $chunks, $this->options->host),
            );
        } catch (TimeoutExceptionInterface $exception) {
            throw new TimeoutException(sprintf('Docker stream request to %s timed out: %s', $this->options->host, $exception->getMessage()), previous: $exception);
        } catch (TransportExceptionInterface $exception) {
            throw TransportException::connection($this->options->host, $exception->getMessage(), $exception);
        }
    }

    /** @return array<string, mixed> */
    private function requestOptions(Request $request, bool $stream): array
    {
        $headers = [...$this->options->headers, ...$request->headers];
        $requestTimeout = $request->timeout ?? $this->options->timeouts->request;
        $streamIdleTimeout = $request->streamIdleTimeout ?? $this->options->timeouts->streamIdle;
        $options = [
            'headers'              => $headers,
            'http_version'         => '1.1',
            'max_redirects'        => 0,
            'max_connect_duration' => $this->options->timeouts->connect,
            'max_duration'         => $stream ? 0.0 : $requestTimeout,
            'timeout'              => $stream ? ($streamIdleTimeout ?? 0.0) : $requestTimeout,
            'buffer'               => ! $stream,
        ];

        if (str_starts_with($this->options->host, 'unix://')) {
            $options['bindto'] = mb_substr($this->options->host, 7);
        }

        if (null !== $this->options->tls) {
            $options += [
                'verify_peer' => $this->options->tls->verifyPeer,
                'verify_host' => $this->options->tls->verifyHost,
                'cafile'      => $this->options->tls->ca,
                'local_cert'  => $this->options->tls->certificate,
                'local_pk'    => $this->options->tls->privateKey,
                'passphrase'  => $this->options->tls->privateKeyPassword,
            ];
        }

        if ($request->body instanceof Stream) {
            $body = $request->body;
            $options['body'] = static fn(int $length): string => $body->eof() ? '' : $body->read($length);
            $options['headers'] += ['Content-Type' => 'application/octet-stream'];
        } elseif (is_object($request->body)) {
            $options['json'] = $this->serializer->normalize($request->body);
        } elseif (is_array($request->body)) {
            $options['json'] = $request->body;
        } elseif (is_string($request->body)) {
            $options['body'] = $request->body;
            $options['headers'] += ['Content-Type' => 'application/octet-stream'];
        }

        return $options;
    }

    private function url(Request $request): string
    {
        $base = str_starts_with($this->options->host, 'unix://') ? 'http://localhost' : $this->options->host;

        return $base . $request->target();
    }

    private function method(Request $request): string
    {
        $method = mb_strtoupper(mb_trim($request->method));

        if ('' === $method) {
            throw new TransportException('Docker HTTP method cannot be empty.');
        }

        return $method;
    }

    private function isUpgraded(Request $request): bool
    {
        foreach ($request->headers as $name => $value) {
            if (0 === strcasecmp($name, 'Connection') && str_contains(mb_strtolower($value), 'upgrade')) {
                return true;
            }
        }

        return false;
    }
}
