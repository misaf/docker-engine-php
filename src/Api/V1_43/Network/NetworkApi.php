<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_43\Network;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Generated\ResponseKind;

final class NetworkApi extends GeneratedApi
{
    public function connect(Requests\NetworkConnectRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'NetworkConnect',
            method: 'POST',
            path: '/networks/{id}/connect',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function create(Requests\NetworkCreateRequest $request): Responses\NetworkCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'NetworkCreate',
            method: 'POST',
            path: '/networks/create',
            responseClass: Responses\NetworkCreateResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\NetworkCreateResponse) {
            throw new InvalidResponseException('Docker operation NetworkCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\NetworkDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\NetworkId $request): void
    {
        $request = $request instanceof Requests\NetworkDeleteRequest
            ? $request
            : new Requests\NetworkDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'NetworkDelete',
            method: 'DELETE',
            path: '/networks/{id}',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function disconnect(Requests\NetworkDisconnectRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'NetworkDisconnect',
            method: 'POST',
            path: '/networks/{id}/disconnect',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\NetworkInspectRequest|string|\Misaf\DockerEngine\ValueObjects\NetworkId $request): Responses\NetworkInspectResponse
    {
        $request = $request instanceof Requests\NetworkInspectRequest
            ? $request
            : new Requests\NetworkInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'NetworkInspect',
            method: 'GET',
            path: '/networks/{id}',
            responseClass: Responses\NetworkInspectResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\NetworkInspectResponse) {
            throw new InvalidResponseException('Docker operation NetworkInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\NetworkListRequest $request = null): Responses\NetworkListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'NetworkList',
            method: 'GET',
            path: '/networks',
            responseClass: Responses\NetworkListResponse::class,
            responseKind: ResponseKind::JsonArray,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\NetworkListResponse) {
            throw new InvalidResponseException('Docker operation NetworkList returned an unexpected response type.');
        }

        return $result;
    }

    public function prune(?Requests\NetworkPruneRequest $request = null): Responses\NetworkPruneResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'NetworkPrune',
            method: 'POST',
            path: '/networks/prune',
            responseClass: Responses\NetworkPruneResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\NetworkPruneResponse) {
            throw new InvalidResponseException('Docker operation NetworkPrune returned an unexpected response type.');
        }

        return $result;
    }
}
