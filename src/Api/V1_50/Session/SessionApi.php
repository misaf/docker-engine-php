<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Session;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Transport\StreamResponse;

final class SessionApi extends GeneratedApi
{
    public function session(): StreamResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'Session',
            method: 'POST',
            path: '/session',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: 'tcp',
        ));

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation Session returned an unexpected response type.');
        }

        return $result;
    }
}
