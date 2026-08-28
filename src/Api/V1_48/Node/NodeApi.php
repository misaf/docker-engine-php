<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\Node;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class NodeApi extends GeneratedApi
{
    public function remove(Requests\NodeDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\NodeId $request): void
    {
        $request = $request instanceof Requests\NodeDeleteRequest
            ? $request
            : new Requests\NodeDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'NodeDelete',
            method: 'DELETE',
            path: '/nodes/{id}',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\NodeInspectRequest|string|\Misaf\DockerEngine\ValueObjects\NodeId $request): Responses\NodeInspectResponse
    {
        $request = $request instanceof Requests\NodeInspectRequest
            ? $request
            : new Requests\NodeInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'NodeInspect',
            method: 'GET',
            path: '/nodes/{id}',
            responseClass: Responses\NodeInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\NodeInspectResponse) {
            throw new InvalidResponseException('Docker operation NodeInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\NodeListRequest $request = null): Responses\NodeListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'NodeList',
            method: 'GET',
            path: '/nodes',
            responseClass: Responses\NodeListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\NodeListResponse) {
            throw new InvalidResponseException('Docker operation NodeList returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\NodeUpdateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'NodeUpdate',
            method: 'POST',
            path: '/nodes/{id}/update',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
