<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Exec;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\ConnectionUpgrade;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedExecApi;
use Misaf\DockerEngine\Generated\ResponseKind;
use Misaf\DockerEngine\Transport\StreamResponse;

final class ExecApi extends GeneratedExecApi
{
    public function create(Requests\ContainerExecRequest $request): Responses\ContainerExecResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ContainerExec',
            method: 'POST',
            path: '/containers/{id}/exec',
            responseClass: Responses\ContainerExecResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ContainerExecResponse) {
            throw new InvalidResponseException('Docker operation ContainerExec returned an unexpected response type.');
        }

        return $result;
    }

    public function inspect(Requests\ExecInspectRequest|string|\Misaf\DockerEngine\ValueObjects\ExecId $request): Responses\ExecInspectResponse
    {
        $request = $request instanceof Requests\ExecInspectRequest
            ? $request
            : new Requests\ExecInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ExecInspect',
            method: 'GET',
            path: '/exec/{id}/json',
            responseClass: Responses\ExecInspectResponse::class,
            responseKind: ResponseKind::Json,
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\ExecInspectResponse) {
            throw new InvalidResponseException('Docker operation ExecInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function resize(Requests\ExecResizeRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'ExecResize',
            method: 'POST',
            path: '/exec/{id}/resize',
            responseClass: null,
            responseKind: ResponseKind::Void,
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function start(Requests\ExecStartRequest|string|\Misaf\DockerEngine\ValueObjects\ExecId $request): StreamResponse
    {
        $request = $request instanceof Requests\ExecStartRequest
            ? $request
            : new Requests\ExecStartRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ExecStart',
            method: 'POST',
            path: '/exec/{id}/start',
            responseClass: null,
            responseKind: ResponseKind::Stream,
            deprecated: false,
            upgrade: ConnectionUpgrade::Tcp,
        ), $request);

        if ( ! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ExecStart returned an unexpected response type.');
        }

        return $result;
    }
}
