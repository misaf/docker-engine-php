<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use JsonException;
use Misaf\DockerEngine\Exceptions\ApiException;
use Misaf\DockerEngine\Exceptions\BadRequestException;
use Misaf\DockerEngine\Exceptions\ConflictException;
use Misaf\DockerEngine\Exceptions\ForbiddenException;
use Misaf\DockerEngine\Exceptions\NotFoundException;
use Misaf\DockerEngine\Exceptions\ServerException;
use Misaf\DockerEngine\Exceptions\UnauthorizedException;
use Misaf\DockerEngine\Exceptions\ValidationException;
use Misaf\DockerEngine\Transport\Response;

final class ErrorMapper
{
    public function exception(Response $response): ApiException
    {
        $message = $this->message($response);
        $class = match ($response->statusCode) {
            400     => BadRequestException::class,
            401     => UnauthorizedException::class,
            403     => ForbiddenException::class,
            404     => NotFoundException::class,
            409     => ConflictException::class,
            422     => ValidationException::class,
            default => $response->statusCode >= 500 ? ServerException::class : ApiException::class,
        };

        return new $class($message, $response->statusCode, $response->headers, $response->body);
    }

    private function message(Response $response): string
    {
        try {
            $decoded = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
            $message = is_array($decoded) ? ($decoded['message'] ?? null) : null;

            if (is_string($message) && '' !== $message) {
                return $message;
            }
        } catch (JsonException) {
            // The daemon occasionally returns plain text for proxy errors.
        }

        return '' !== mb_trim($response->body)
            ? mb_trim($response->body)
            : sprintf('Docker Engine API request failed with HTTP %d.', $response->statusCode);
    }
}
