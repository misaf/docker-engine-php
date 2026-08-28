<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Config;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class ConfigApi extends GeneratedApi
{
    public function create(?Requests\ConfigCreateRequest $request = null): Responses\ConfigCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ConfigCreate',
            method: 'POST',
            path: '/configs/create',
            responseClass: Responses\ConfigCreateResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ConfigCreateResponse) {
            throw new InvalidResponseException('Docker operation ConfigCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\ConfigDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\ConfigId $request): void
    {
        $request = $request instanceof Requests\ConfigDeleteRequest
            ? $request
            : new Requests\ConfigDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ConfigDelete',
            method: 'DELETE',
            path: '/configs/{id}',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\ConfigInspectRequest|string|\Misaf\DockerEngine\ValueObjects\ConfigId $request): Responses\ConfigInspectResponse
    {
        $request = $request instanceof Requests\ConfigInspectRequest
            ? $request
            : new Requests\ConfigInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ConfigInspect',
            method: 'GET',
            path: '/configs/{id}',
            responseClass: Responses\ConfigInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ConfigInspectResponse) {
            throw new InvalidResponseException('Docker operation ConfigInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\ConfigListRequest $request = null): Responses\ConfigListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ConfigList',
            method: 'GET',
            path: '/configs',
            responseClass: Responses\ConfigListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ConfigListResponse) {
            throw new InvalidResponseException('Docker operation ConfigList returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\ConfigUpdateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'ConfigUpdate',
            method: 'POST',
            path: '/configs/{id}/update',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
