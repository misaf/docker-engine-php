<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_52\Container;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Transport\StreamResponse;

final class ContainerApi extends GeneratedApi
{
    public function archive(Requests\ContainerArchiveRequest $request): StreamResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerArchive',
            method: 'GET',
            path: '/containers/{id}/archive',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerArchive returned an unexpected response type.');
        }

        return $result;
    }

    public function archiveInfo(Requests\ContainerArchiveInfoRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'ContainerArchiveInfo',
            method: 'HEAD',
            path: '/containers/{id}/archive',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function attach(Requests\ContainerAttachRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): StreamResponse
    {
        $request = $request instanceof Requests\ContainerAttachRequest
            ? $request
            : new Requests\ContainerAttachRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerAttach',
            method: 'POST',
            path: '/containers/{id}/attach',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: 'tcp',
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerAttach returned an unexpected response type.');
        }

        return $result;
    }

    public function attachWebsocket(Requests\ContainerAttachWebsocketRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): StreamResponse
    {
        $request = $request instanceof Requests\ContainerAttachWebsocketRequest
            ? $request
            : new Requests\ContainerAttachWebsocketRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerAttachWebsocket',
            method: 'GET',
            path: '/containers/{id}/attach/ws',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: 'websocket',
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerAttachWebsocket returned an unexpected response type.');
        }

        return $result;
    }

    public function changes(Requests\ContainerChangesRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): Responses\ContainerChangesResponse
    {
        $request = $request instanceof Requests\ContainerChangesRequest
            ? $request
            : new Requests\ContainerChangesRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerChanges',
            method: 'GET',
            path: '/containers/{id}/changes',
            responseClass: Responses\ContainerChangesResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerChangesResponse) {
            throw new InvalidResponseException('Docker operation ContainerChanges returned an unexpected response type.');
        }

        return $result;
    }

    public function create(Requests\ContainerCreateRequest $request): Responses\ContainerCreateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerCreate',
            method: 'POST',
            path: '/containers/create',
            responseClass: Responses\ContainerCreateResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerCreateResponse) {
            throw new InvalidResponseException('Docker operation ContainerCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\ContainerDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerDeleteRequest
            ? $request
            : new Requests\ContainerDeleteRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerDelete',
            method: 'DELETE',
            path: '/containers/{id}',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function export(Requests\ContainerExportRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): StreamResponse
    {
        $request = $request instanceof Requests\ContainerExportRequest
            ? $request
            : new Requests\ContainerExportRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerExport',
            method: 'GET',
            path: '/containers/{id}/export',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerExport returned an unexpected response type.');
        }

        return $result;
    }

    public function inspect(Requests\ContainerInspectRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): Responses\ContainerInspectResponse
    {
        $request = $request instanceof Requests\ContainerInspectRequest
            ? $request
            : new Requests\ContainerInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerInspect',
            method: 'GET',
            path: '/containers/{id}/json',
            responseClass: Responses\ContainerInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerInspectResponse) {
            throw new InvalidResponseException('Docker operation ContainerInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function kill(Requests\ContainerKillRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerKillRequest
            ? $request
            : new Requests\ContainerKillRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerKill',
            method: 'POST',
            path: '/containers/{id}/kill',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function list(?Requests\ContainerListRequest $request = null): Responses\ContainerListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerList',
            method: 'GET',
            path: '/containers/json',
            responseClass: Responses\ContainerListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerListResponse) {
            throw new InvalidResponseException('Docker operation ContainerList returned an unexpected response type.');
        }

        return $result;
    }

    public function logs(Requests\ContainerLogsRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): StreamResponse
    {
        $request = $request instanceof Requests\ContainerLogsRequest
            ? $request
            : new Requests\ContainerLogsRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerLogs',
            method: 'GET',
            path: '/containers/{id}/logs',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerLogs returned an unexpected response type.');
        }

        return $result;
    }

    public function pause(Requests\ContainerPauseRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerPauseRequest
            ? $request
            : new Requests\ContainerPauseRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerPause',
            method: 'POST',
            path: '/containers/{id}/pause',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function prune(?Requests\ContainerPruneRequest $request = null): Responses\ContainerPruneResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerPrune',
            method: 'POST',
            path: '/containers/prune',
            responseClass: Responses\ContainerPruneResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerPruneResponse) {
            throw new InvalidResponseException('Docker operation ContainerPrune returned an unexpected response type.');
        }

        return $result;
    }

    public function rename(Requests\ContainerRenameRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'ContainerRename',
            method: 'POST',
            path: '/containers/{id}/rename',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function resize(Requests\ContainerResizeRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'ContainerResize',
            method: 'POST',
            path: '/containers/{id}/resize',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function restart(Requests\ContainerRestartRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerRestartRequest
            ? $request
            : new Requests\ContainerRestartRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerRestart',
            method: 'POST',
            path: '/containers/{id}/restart',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function start(Requests\ContainerStartRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerStartRequest
            ? $request
            : new Requests\ContainerStartRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerStart',
            method: 'POST',
            path: '/containers/{id}/start',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function stats(Requests\ContainerStatsRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): StreamResponse
    {
        $request = $request instanceof Requests\ContainerStatsRequest
            ? $request
            : new Requests\ContainerStatsRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerStats',
            method: 'GET',
            path: '/containers/{id}/stats',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ContainerStats returned an unexpected response type.');
        }

        return $result;
    }

    public function stop(Requests\ContainerStopRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerStopRequest
            ? $request
            : new Requests\ContainerStopRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerStop',
            method: 'POST',
            path: '/containers/{id}/stop',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function top(Requests\ContainerTopRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): Responses\ContainerTopResponse
    {
        $request = $request instanceof Requests\ContainerTopRequest
            ? $request
            : new Requests\ContainerTopRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerTop',
            method: 'GET',
            path: '/containers/{id}/top',
            responseClass: Responses\ContainerTopResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerTopResponse) {
            throw new InvalidResponseException('Docker operation ContainerTop returned an unexpected response type.');
        }

        return $result;
    }

    public function unpause(Requests\ContainerUnpauseRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): void
    {
        $request = $request instanceof Requests\ContainerUnpauseRequest
            ? $request
            : new Requests\ContainerUnpauseRequest(id: $request);

        $this->call(new Endpoint(
            operationId: 'ContainerUnpause',
            method: 'POST',
            path: '/containers/{id}/unpause',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function update(Requests\ContainerUpdateRequest $request): Responses\ContainerUpdateResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerUpdate',
            method: 'POST',
            path: '/containers/{id}/update',
            responseClass: Responses\ContainerUpdateResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerUpdateResponse) {
            throw new InvalidResponseException('Docker operation ContainerUpdate returned an unexpected response type.');
        }

        return $result;
    }

    public function wait(Requests\ContainerWaitRequest|string|\Misaf\DockerEngine\ValueObjects\ContainerId $request): Responses\ContainerWaitResponse
    {
        $request = $request instanceof Requests\ContainerWaitRequest
            ? $request
            : new Requests\ContainerWaitRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ContainerWait',
            method: 'POST',
            path: '/containers/{id}/wait',
            responseClass: Responses\ContainerWaitResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerWaitResponse) {
            throw new InvalidResponseException('Docker operation ContainerWait returned an unexpected response type.');
        }

        return $result;
    }

    public function putArchive(Requests\PutContainerArchiveRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'PutContainerArchive',
            method: 'PUT',
            path: '/containers/{id}/archive',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
