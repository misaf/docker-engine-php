<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Secret;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class SecretApi extends GeneratedApi
{
    public function create(?Requests\SecretCreateRequest $request = null): Responses\SecretCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SecretCreate',
            method: 'POST',
            path: '/secrets/create',
            responseClass: Responses\SecretCreateResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\SecretCreateResponse) {
            throw new InvalidResponseException('Docker operation SecretCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\SecretDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\SecretId $request): void
    {
        $request = $request instanceof Requests\SecretDeleteRequest
            ? $request
            : new Requests\SecretDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'SecretDelete',
            method: 'DELETE',
            path: '/secrets/{id}',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\SecretInspectRequest|string|\Misaf\DockerEngine\ValueObjects\SecretId $request): Responses\SecretInspectResponse
    {
        $request = $request instanceof Requests\SecretInspectRequest
            ? $request
            : new Requests\SecretInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'SecretInspect',
            method: 'GET',
            path: '/secrets/{id}',
            responseClass: Responses\SecretInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\SecretInspectResponse) {
            throw new InvalidResponseException('Docker operation SecretInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\SecretListRequest $request = null): Responses\SecretListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SecretList',
            method: 'GET',
            path: '/secrets',
            responseClass: Responses\SecretListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\SecretListResponse) {
            throw new InvalidResponseException('Docker operation SecretList returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\SecretUpdateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'SecretUpdate',
            method: 'POST',
            path: '/secrets/{id}/update',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
