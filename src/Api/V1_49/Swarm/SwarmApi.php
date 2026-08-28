<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Swarm;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedApi;

final class SwarmApi extends GeneratedApi
{
    public function init(Requests\SwarmInitRequest $request): string
    {
        $result = $this->call(new Endpoint(
            operationId: 'SwarmInit',
            method: 'POST',
            path: '/swarm/init',
            responseClass: null,
            responseKind: 'raw',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! is_string($result)) {
            throw new InvalidResponseException('Docker operation SwarmInit did not return a primitive response.');
        }

        return $result;
    }

    public function inspect(): Responses\SwarmInspectResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SwarmInspect',
            method: 'GET',
            path: '/swarm',
            responseClass: Responses\SwarmInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ));

        if (! $result instanceof Responses\SwarmInspectResponse) {
            throw new InvalidResponseException('Docker operation SwarmInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function join(Requests\SwarmJoinRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'SwarmJoin',
            method: 'POST',
            path: '/swarm/join',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function leave(?Requests\SwarmLeaveRequest $request = null): void
    {
        $this->call(new Endpoint(
            operationId: 'SwarmLeave',
            method: 'POST',
            path: '/swarm/leave',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function unlock(Requests\SwarmUnlockRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'SwarmUnlock',
            method: 'POST',
            path: '/swarm/unlock',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }

    public function unlockKey(): Responses\SwarmUnlockkeyResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'SwarmUnlockkey',
            method: 'GET',
            path: '/swarm/unlockkey',
            responseClass: Responses\SwarmUnlockkeyResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ));

        if (! $result instanceof Responses\SwarmUnlockkeyResponse) {
            throw new InvalidResponseException('Docker operation SwarmUnlockkey returned an unexpected response type.');
        }

        return $result;
    }

    public function update(Requests\SwarmUpdateRequest $request): void
    {
        $this->call(new Endpoint(
            operationId: 'SwarmUpdate',
            method: 'POST',
            path: '/swarm/update',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
