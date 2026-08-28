<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Plugin;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;
use Misaf\DockerEngine\Streaming\ProgressStream;

final class PluginApi extends GeneratedApi
{
    public function privileges(Requests\GetPluginPrivilegesRequest $request): Responses\GetPluginPrivilegesResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'GetPluginPrivileges',
            method: 'GET',
            path: '/plugins/privileges',
            responseClass: Responses\GetPluginPrivilegesResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\GetPluginPrivilegesResponse) {
            throw new InvalidResponseException('Docker operation GetPluginPrivileges returned an unexpected response type.');
        }

        return $result;
    }

    public function create(Requests\PluginCreateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'PluginCreate',
            method: 'POST',
            path: '/plugins/create',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function remove(Requests\PluginDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): Responses\PluginDeleteResponse
    {
        $request = $request instanceof Requests\PluginDeleteRequest
            ? $request
            : new Requests\PluginDeleteRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'PluginDelete',
            method: 'DELETE',
            path: '/plugins/{name}',
            responseClass: Responses\PluginDeleteResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\PluginDeleteResponse) {
            throw new InvalidResponseException('Docker operation PluginDelete returned an unexpected response type.');
        }

        return $result;
    }

    public function disable(Requests\PluginDisableRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): void
    {
        $request = $request instanceof Requests\PluginDisableRequest
            ? $request
            : new Requests\PluginDisableRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'PluginDisable',
            method: 'POST',
            path: '/plugins/{name}/disable',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function enable(Requests\PluginEnableRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): void
    {
        $request = $request instanceof Requests\PluginEnableRequest
            ? $request
            : new Requests\PluginEnableRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'PluginEnable',
            method: 'POST',
            path: '/plugins/{name}/enable',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function inspect(Requests\PluginInspectRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): Responses\PluginInspectResponse
    {
        $request = $request instanceof Requests\PluginInspectRequest
            ? $request
            : new Requests\PluginInspectRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'PluginInspect',
            method: 'GET',
            path: '/plugins/{name}/json',
            responseClass: Responses\PluginInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\PluginInspectResponse) {
            throw new InvalidResponseException('Docker operation PluginInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\PluginListRequest $request = null): Responses\PluginListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'PluginList',
            method: 'GET',
            path: '/plugins',
            responseClass: Responses\PluginListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\PluginListResponse) {
            throw new InvalidResponseException('Docker operation PluginList returned an unexpected response type.');
        }

        return $result;
    }

    public function pull(Requests\PluginPullRequest $request): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'PluginPull',
            method: 'POST',
            path: '/plugins/pull',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation PluginPull returned an unexpected response type.');
        }

        return $result;
    }

    public function push(Requests\PluginPushRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): void
    {
        $request = $request instanceof Requests\PluginPushRequest
            ? $request
            : new Requests\PluginPushRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'PluginPush',
            method: 'POST',
            path: '/plugins/{name}/push',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function set(Requests\PluginSetRequest|string|\Misaf\DockerEngine\ValueObjects\PluginName $request): void
    {
        $request = $request instanceof Requests\PluginSetRequest
            ? $request
            : new Requests\PluginSetRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'PluginSet',
            method: 'POST',
            path: '/plugins/{name}/set',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function upgrade(Requests\PluginUpgradeRequest $request): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'PluginUpgrade',
            method: 'POST',
            path: '/plugins/{name}/upgrade',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation PluginUpgrade returned an unexpected response type.');
        }

        return $result;
    }
}
