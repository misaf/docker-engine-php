<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Task;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Transport\StreamResponse;

final class TaskApi extends GeneratedApi
{
    public function inspect(Requests\TaskInspectRequest|string|\Misaf\DockerEngine\ValueObjects\TaskId $request): Responses\TaskInspectResponse
    {
        $request = $request instanceof Requests\TaskInspectRequest
            ? $request
            : new Requests\TaskInspectRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'TaskInspect',
            method: 'GET',
            path: '/tasks/{id}',
            responseClass: Responses\TaskInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\TaskInspectResponse) {
            throw new InvalidResponseException('Docker operation TaskInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\TaskListRequest $request = null): Responses\TaskListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'TaskList',
            method: 'GET',
            path: '/tasks',
            responseClass: Responses\TaskListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\TaskListResponse) {
            throw new InvalidResponseException('Docker operation TaskList returned an unexpected response type.');
        }

        return $result;
    }

    public function logs(Requests\TaskLogsRequest|string|\Misaf\DockerEngine\ValueObjects\TaskId $request): StreamResponse
    {
        $request = $request instanceof Requests\TaskLogsRequest
            ? $request
            : new Requests\TaskLogsRequest(id: $request);

        $result = $this->call(new Endpoint(
            operationId: 'TaskLogs',
            method: 'GET',
            path: '/tasks/{id}/logs',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation TaskLogs returned an unexpected response type.');
        }

        return $result;
    }
}
