<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Service;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Generated\ResponseKind;
use Misaf\DockerEngine\Transport\StreamResponse;

final class ServiceApi extends GeneratedApi
{
    public function create(Requests\ServiceCreateRequest $request): Responses\ServiceCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ServiceCreate',
            method: 'POST',
            path: '/services/create',
            responseClass: Responses\ServiceCreateResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ServiceCreateResponse) {
            throw new InvalidResponseException('Docker operation ServiceCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\ServiceDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\ServiceId $request): void
    {
        $request = $request instanceof Requests\ServiceDeleteRequest
            ? $request
            : new Requests\ServiceDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ServiceDelete',
            method: 'DELETE',
            path: '/services/{id}',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\ServiceInspectRequest|string|\Misaf\DockerEngine\ValueObjects\ServiceId $request): Responses\ServiceInspectResponse
    {
        $request = $request instanceof Requests\ServiceInspectRequest
            ? $request
            : new Requests\ServiceInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ServiceInspect',
            method: 'GET',
            path: '/services/{id}',
            responseClass: Responses\ServiceInspectResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ServiceInspectResponse) {
            throw new InvalidResponseException('Docker operation ServiceInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\ServiceListRequest $request = null): Responses\ServiceListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ServiceList',
            method: 'GET',
            path: '/services',
            responseClass: Responses\ServiceListResponse::class,
            responseKind: ResponseKind::JsonArray,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ServiceListResponse) {
            throw new InvalidResponseException('Docker operation ServiceList returned an unexpected response type.');
        }

        return $result;
    }

    public function logs(Requests\ServiceLogsRequest|string|\Misaf\DockerEngine\ValueObjects\ServiceId $request): StreamResponse
    {
        $request = $request instanceof Requests\ServiceLogsRequest
            ? $request
            : new Requests\ServiceLogsRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ServiceLogs',
            method: 'GET',
            path: '/services/{id}/logs',
            responseClass: null,
            responseKind: ResponseKind::Stream,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ServiceLogs returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\ServiceUpdateRequest $request): Responses\ServiceUpdateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ServiceUpdate',
            method: 'POST',
            path: '/services/{id}/update',
            responseClass: Responses\ServiceUpdateResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ServiceUpdateResponse) {
            throw new InvalidResponseException('Docker operation ServiceUpdate returned an unexpected response type.');
        }

        return $result;
    }
}
