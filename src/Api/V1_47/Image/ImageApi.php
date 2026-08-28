<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Image;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\GeneratedImageApi;
use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\Transport\StreamResponse;

final class ImageApi extends GeneratedImageApi
{
    public function pruneBuildCache(?Requests\BuildPruneRequest $request = null): Responses\BuildPruneResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'BuildPrune',
            method: 'POST',
            path: '/build/prune',
            responseClass: Responses\BuildPruneResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\BuildPruneResponse) {
            throw new InvalidResponseException('Docker operation BuildPrune returned an unexpected response type.');
        }

        return $result;
    }

    public function build(?Requests\ImageBuildRequest $request = null): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageBuild',
            method: 'POST',
            path: '/build',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation ImageBuild returned an unexpected response type.');
        }

        return $result;
    }

    public function commit(?Requests\ImageCommitRequest $request = null): Responses\ImageCommitResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageCommit',
            method: 'POST',
            path: '/commit',
            responseClass: Responses\ImageCommitResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageCommitResponse) {
            throw new InvalidResponseException('Docker operation ImageCommit returned an unexpected response type.');
        }

        return $result;
    }

    public function create(?Requests\ImageCreateRequest $request = null): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageCreate',
            method: 'POST',
            path: '/images/create',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation ImageCreate returned an unexpected response type.');
        }

        return $result;
    }

    public function remove(Requests\ImageDeleteRequest|string|\Misaf\DockerEngine\ValueObjects\ImageReference $request): Responses\ImageDeleteResponse
    {
        $request = $request instanceof Requests\ImageDeleteRequest
            ? $request
            : new Requests\ImageDeleteRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ImageDelete',
            method: 'DELETE',
            path: '/images/{name}',
            responseClass: Responses\ImageDeleteResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageDeleteResponse) {
            throw new InvalidResponseException('Docker operation ImageDelete returned an unexpected response type.');
        }

        return $result;
    }

    public function get(Requests\ImageGetRequest|string|\Misaf\DockerEngine\ValueObjects\ImageReference $request): StreamResponse
    {
        $request = $request instanceof Requests\ImageGetRequest
            ? $request
            : new Requests\ImageGetRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ImageGet',
            method: 'GET',
            path: '/images/{name}/get',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ImageGet returned an unexpected response type.');
        }

        return $result;
    }

    public function getAll(?Requests\ImageGetAllRequest $request = null): StreamResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageGetAll',
            method: 'GET',
            path: '/images/get',
            responseClass: null,
            responseKind: 'stream',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof StreamResponse) {
            throw new InvalidResponseException('Docker operation ImageGetAll returned an unexpected response type.');
        }

        return $result;
    }

    public function history(Requests\ImageHistoryRequest|string|\Misaf\DockerEngine\ValueObjects\ImageReference $request): Responses\ImageHistoryResponse
    {
        $request = $request instanceof Requests\ImageHistoryRequest
            ? $request
            : new Requests\ImageHistoryRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ImageHistory',
            method: 'GET',
            path: '/images/{name}/history',
            responseClass: Responses\ImageHistoryResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageHistoryResponse) {
            throw new InvalidResponseException('Docker operation ImageHistory returned an unexpected response type.');
        }

        return $result;
    }

    public function inspect(Requests\ImageInspectRequest|string|\Misaf\DockerEngine\ValueObjects\ImageReference $request): Responses\ImageInspectResponse
    {
        $request = $request instanceof Requests\ImageInspectRequest
            ? $request
            : new Requests\ImageInspectRequest(name: $request);

        $result = $this->call(new Endpoint(
            operationId: 'ImageInspect',
            method: 'GET',
            path: '/images/{name}/json',
            responseClass: Responses\ImageInspectResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageInspectResponse) {
            throw new InvalidResponseException('Docker operation ImageInspect returned an unexpected response type.');
        }

        return $result;
    }

    public function list(?Requests\ImageListRequest $request = null): Responses\ImageListResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageList',
            method: 'GET',
            path: '/images/json',
            responseClass: Responses\ImageListResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageListResponse) {
            throw new InvalidResponseException('Docker operation ImageList returned an unexpected response type.');
        }

        return $result;
    }

    public function load(?Requests\ImageLoadRequest $request = null): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageLoad',
            method: 'POST',
            path: '/images/load',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation ImageLoad returned an unexpected response type.');
        }

        return $result;
    }

    public function prune(?Requests\ImagePruneRequest $request = null): Responses\ImagePruneResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImagePrune',
            method: 'POST',
            path: '/images/prune',
            responseClass: Responses\ImagePruneResponse::class,
            responseKind: 'json',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImagePruneResponse) {
            throw new InvalidResponseException('Docker operation ImagePrune returned an unexpected response type.');
        }

        return $result;
    }

    public function push(Requests\ImagePushRequest $request): ProgressStream
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImagePush',
            method: 'POST',
            path: '/images/{name}/push',
            responseClass: null,
            responseKind: 'progress',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof ProgressStream) {
            throw new InvalidResponseException('Docker operation ImagePush returned an unexpected response type.');
        }

        return $result;
    }

    public function search(Requests\ImageSearchRequest $request): Responses\ImageSearchResponse
    {
        $result = $this->call(new Endpoint(
            operationId: 'ImageSearch',
            method: 'GET',
            path: '/images/search',
            responseClass: Responses\ImageSearchResponse::class,
            responseKind: 'json-array',
            deprecated: false,
            upgrade: null,
        ), $request);

        if (! $result instanceof Responses\ImageSearchResponse) {
            throw new InvalidResponseException('Docker operation ImageSearch returned an unexpected response type.');
        }

        return $result;
    }

    public function tag(Requests\ImageTagRequest|string|\Misaf\DockerEngine\ValueObjects\ImageReference $request): void
    {
        $request = $request instanceof Requests\ImageTagRequest
            ? $request
            : new Requests\ImageTagRequest(name: $request);

        $this->call(new Endpoint(
            operationId: 'ImageTag',
            method: 'POST',
            path: '/images/{name}/tag',
            responseClass: null,
            responseKind: 'void',
            deprecated: false,
            upgrade: null,
        ), $request);
    }
}
