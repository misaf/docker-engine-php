<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\ErrorMapper;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;

abstract class GeneratedApi
{
    public function __construct(
        protected readonly Transport $transport,
        protected readonly ApiVersion $version,
        protected readonly Serializer $serializer,
        protected readonly ErrorMapper $errors,
    ) {}

    protected function call(Endpoint $endpoint, ?GeneratedRequest $input = null): object|string|null
    {
        $request = $this->request($endpoint, $input);

        if (in_array($endpoint->responseKind, ['stream', 'progress'], true)) {
            $response = $this->transport->stream($request);
            $this->assertStreamSuccess($response);

            return 'progress' === $endpoint->responseKind ? new ProgressStream($response->stream) : $response;
        }

        $response = $this->transport->request($request);

        if (! $response->successful()) {
            throw $this->errors->exception($response);
        }

        if ('raw' === $endpoint->responseKind) {
            return $response->body;
        }

        if (null === $endpoint->responseClass || '' === $response->body) {
            return null;
        }

        $data = $response->json();

        if (str_starts_with($endpoint->responseClass, 'list<')) {
            throw new InvalidResponseException('Internal generator error: list response classes must use an endpoint response DTO.');
        }

        return $this->serializer->denormalize(
            'json-array' === $endpoint->responseKind ? ['items' => $data] : $data,
            $endpoint->responseClass,
        );
    }

    private function request(Endpoint $endpoint, ?GeneratedRequest $input): Request
    {
        $parts = ($input ?? new EmptyRequest())->parts($this->serializer);
        $path = $endpoint->path;

        foreach ($parts['path'] as $name => $value) {
            $path = str_replace('{' . $name . '}', rawurlencode((string) $value), $path);
        }

        if (str_contains($path, '{')) {
            throw new InvalidResponseException(sprintf('Operation %s is missing a required path parameter.', $endpoint->operationId));
        }

        $headers = $parts['headers'];

        if (null !== $endpoint->upgrade) {
            $headers += ['Connection' => 'Upgrade', 'Upgrade' => $endpoint->upgrade];

            if ('websocket' === $endpoint->upgrade) {
                $headers += [
                    'Sec-WebSocket-Key'     => base64_encode(random_bytes(16)),
                    'Sec-WebSocket-Version' => '13',
                ];
            }
        }

        return new Request(
            method: $endpoint->method,
            path: $path,
            version: $this->version,
            query: $parts['query'],
            headers: $headers,
            body: $parts['body'],
        );
    }

    private function assertStreamSuccess(StreamResponse $response): void
    {
        if (101 === $response->statusCode || ($response->statusCode >= 200 && $response->statusCode < 300)) {
            return;
        }

        $body = '';

        while (! $response->stream->eof()) {
            $body .= $response->stream->read();
        }

        throw $this->errors->exception(new Response($response->statusCode, $response->headers, $body));
    }
}
