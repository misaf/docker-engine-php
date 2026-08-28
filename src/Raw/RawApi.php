<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Raw;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\ErrorMapper;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;

final readonly class RawApi
{
    public function __construct(
        private Transport $transport,
        private ApiVersion $version,
        private ErrorMapper $errors = new ErrorMapper(),
    ) {}

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param array<string, string> $headers
     * @param array<array-key, mixed>|string|object|Stream|null $body
     */
    public function request(
        string $method,
        string $path,
        array $query = [],
        array $headers = [],
        string|object|array|null $body = null,
        bool $versioned = true,
    ): Response {
        $response = $this->transport->request(new Request(
            $method,
            $path,
            $versioned ? $this->version : null,
            $query,
            $headers,
            $body,
        ));

        if ( ! $response->successful()) {
            throw $this->errors->exception($response);
        }

        return $response;
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param array<string, string> $headers
     * @param array<array-key, mixed>|string|object|Stream|null $body
     */
    public function stream(
        string $method,
        string $path,
        array $query = [],
        array $headers = [],
        string|object|array|null $body = null,
        bool $versioned = true,
    ): StreamResponse {
        $response = $this->transport->stream(new Request(
            $method,
            $path,
            $versioned ? $this->version : null,
            $query,
            $headers,
            $body,
        ));

        if (101 === $response->statusCode || ($response->statusCode >= 200 && $response->statusCode < 300)) {
            return $response;
        }

        $body = '';

        while ( ! $response->stream->eof()) {
            $body .= $response->stream->read();
        }

        throw $this->errors->exception(new Response($response->statusCode, $response->headers, $body));
    }
}
