<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_48\System;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class SystemApi extends GeneratedApi
{
    public function auth(?Requests\SystemAuthRequest $request = null): Responses\SystemAuthResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemAuth',
            method: 'POST',
            path: '/auth',
            responseClass: Responses\SystemAuthResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\SystemAuthResponse) {
            throw new InvalidResponseException('Docker operation SystemAuth returned an unexpected response type.');
        }

        return $result;
    }

    public function dataUsage(?Requests\SystemDataUsageRequest $request = null): Responses\SystemDataUsageResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemDataUsage',
            method: 'GET',
            path: '/system/df',
            responseClass: Responses\SystemDataUsageResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\SystemDataUsageResponse) {
            throw new InvalidResponseException('Docker operation SystemDataUsage returned an unexpected response type.');
        }

        return $result;
    }

    public function events(?Requests\SystemEventsRequest $request = null): Responses\SystemEventsResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemEvents',
            method: 'GET',
            path: '/events',
            responseClass: Responses\SystemEventsResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if ( ! $result instanceof Responses\SystemEventsResponse) {
            throw new InvalidResponseException('Docker operation SystemEvents returned an unexpected response type.');
        }

        return $result;
    }

    public function info(): Responses\SystemInfoResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemInfo',
            method: 'GET',
            path: '/info',
            responseClass: Responses\SystemInfoResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ));

        if ( ! $result instanceof Responses\SystemInfoResponse) {
            throw new InvalidResponseException('Docker operation SystemInfo returned an unexpected response type.');
        }

        return $result;
    }

    public function ping(): string
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemPing',
            method: 'GET',
            path: '/_ping',
            responseClass: null,
            responseKind: 'raw',
            deprecated: false,
            upgrade: null,
        ));

        if ( ! is_string($result)) {
            throw new InvalidResponseException('Docker operation SystemPing did not return a primitive response.');
        }

        return $result;
    }

    public function pingHead(): string
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemPingHead',
            method: 'HEAD',
            path: '/_ping',
            responseClass: null,
            responseKind: 'raw',
            deprecated: false,
            upgrade: null,
        ));

        if ( ! is_string($result)) {
            throw new InvalidResponseException('Docker operation SystemPingHead did not return a primitive response.');
        }

        return $result;
    }

    public function version(): Responses\SystemVersionResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SystemVersion',
            method: 'GET',
            path: '/version',
            responseClass: Responses\SystemVersionResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ));

        if ( ! $result instanceof Responses\SystemVersionResponse) {
            throw new InvalidResponseException('Docker operation SystemVersion returned an unexpected response type.');
        }

        return $result;
    }
}
