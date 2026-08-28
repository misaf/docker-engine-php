<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Distribution;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class DistributionApi extends GeneratedApi
{
    public function inspect(Requests\DistributionInspectRequest|string $request): Responses\DistributionInspectResponse
    {
        $request = $request instanceof Requests\DistributionInspectRequest
            ? $request
            : new Requests\DistributionInspectRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'DistributionInspect',
            method: 'GET',
            path: '/distribution/{name}/json',
            responseClass: Responses\DistributionInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\DistributionInspectResponse) {
            throw new InvalidResponseException('Docker operation DistributionInspect returned an unexpected response type.');
        }

        return $result;
    }
}
