<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Volume;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Generated\ResponseKind;

final class VolumeApi extends GeneratedApi
{
    public function create(Requests\VolumeCreateRequest $request): Responses\VolumeCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'VolumeCreate',
            method: 'POST',
            path: '/volumes/create',
            responseClass: Responses\VolumeCreateResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\VolumeCreateResponse) {
            throw new InvalidResponseException('Docker operation VolumeCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\VolumeDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\VolumeName $request): void
    {
        $request = $request instanceof Requests\VolumeDeleteRequest
            ? $request
            : new Requests\VolumeDeleteRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'VolumeDelete',
            method: 'DELETE',
            path: '/volumes/{name}',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\VolumeInspectRequest|string|\Misaf\DockerEngine\ValueObjects\VolumeName $request): Responses\VolumeInspectResponse
    {
        $request = $request instanceof Requests\VolumeInspectRequest
            ? $request
            : new Requests\VolumeInspectRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'VolumeInspect',
            method: 'GET',
            path: '/volumes/{name}',
            responseClass: Responses\VolumeInspectResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\VolumeInspectResponse) {
            throw new InvalidResponseException('Docker operation VolumeInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\VolumeListRequest $request = null): Responses\VolumeListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'VolumeList',
            method: 'GET',
            path: '/volumes',
            responseClass: Responses\VolumeListResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\VolumeListResponse) {
            throw new InvalidResponseException('Docker operation VolumeList returned an unexpected response type.');
        }

        return $result;
    }

    public function prune(?Requests\VolumePruneRequest $request = null): Responses\VolumePruneResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'VolumePrune',
            method: 'POST',
            path: '/volumes/prune',
            responseClass: Responses\VolumePruneResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\VolumePruneResponse) {
            throw new InvalidResponseException('Docker operation VolumePrune returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\VolumeUpdateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'VolumeUpdate',
            method: 'PUT',
            path: '/volumes/{name}',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
