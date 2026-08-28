<?php

declare(strict_types=1);

use Misaf\DockerEngine\Api\V1_55\Container\Responses\ContainerInspectResponse;
use Misaf\DockerEngine\Api\V1_55\Container\Responses\ContainerListResponse;
use Misaf\DockerEngine\Api\V1_55\Image\Requests\ImageBuildRequest;
use Misaf\DockerEngine\Api\V1_55\System\Responses\SystemVersionResponse;
use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Exceptions\NotFoundException;
use Misaf\DockerEngine\Serialization\SymfonySerializer;
use Misaf\DockerEngine\Tests\Support\FakeDockerTransport;
use Misaf\DockerEngine\Transport\ResourceStream;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;
use Misaf\DockerEngine\ValueObjects\ContainerId;

it('hydrates a regular typed response through the selected version API', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], '{"ApiVersion":"1.55","MinAPIVersion":"1.40","Version":"29.0"}'));
    $client = new DockerClient($transport, ApiVersion::V1_55);
    $response = $client->versioned()->api()->system()->version();

    expect($response)->toBeInstanceOf(SystemVersionResponse::class)
        ->and($response->apiVersion)->toBe('1.55')
        ->and($transport->requests[0]->target())->toBe('/v1.55/version');
});

it('hydrates top-level arrays and nested reusable schemas', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], '[{"Id":"abc","Names":["/web"],"Ports":[{"PrivatePort":80,"Type":"tcp"}]}]'));
    $response = (new DockerClient($transport, ApiVersion::V1_55))->versioned()->api()->container()->list();

    expect($response)->toBeInstanceOf(ContainerListResponse::class)
        ->and($response->items)->toHaveCount(1)
        ->and($response->items[0]->id)->toBe('abc')
        ->and($response->items[0]->ports[0]->privatePort)->toBe(80);
});

it('offers semantic IDs directly for common resource operations', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], '{"Id":"abc","Name":"/web"}'));
    $response = (new DockerClient($transport, ApiVersion::V1_55))->versioned()->api()->container()->inspect(new ContainerId('abc'));

    expect($response)->toBeInstanceOf(ContainerInspectResponse::class)
        ->and($transport->requests[0]->target())->toBe('/v1.55/containers/abc/json');
});

it('maps daemon errors to typed exceptions while preserving the message', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(404, [], '{"message":"No such container: missing"}'));

    expect(fn(): ContainerInspectResponse => (new DockerClient($transport, ApiVersion::V1_55))->versioned()->api()->container()->inspect('missing'))
        ->toThrow(NotFoundException::class, 'No such container: missing');
});

it('uses the selected version and error behavior for raw access', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, ['Content-Type' => ['application/json']], '{"ok":true}'));
    $response = (new DockerClient($transport, ApiVersion::V1_50))->raw()->request('GET', '/future');

    expect($response->json())->toBe(['ok' => true])
        ->and($transport->requests[0]->target())->toBe('/v1.50/future');
});

it('keeps binary request bodies as streams instead of normalizing them', function (): void {
    $stream = ResourceStream::memory('tar context');
    $parts = (new ImageBuildRequest(inputStream: $stream))->parts(new SymfonySerializer());

    expect($parts['body'])->toBe($stream);
});

it('classifies stats and websocket attach as streaming operations', function (): void {
    $transport = new FakeDockerTransport()->queue(
        new StreamResponse(200, [], ResourceStream::memory('{"read":"now"}')),
        new StreamResponse(101, ['Upgrade' => ['websocket']], ResourceStream::memory('attached')),
    );
    $client = new DockerClient($transport, ApiVersion::V1_55);

    expect($client->versioned()->api()->container()->stats('abc'))->toBeInstanceOf(StreamResponse::class)
        ->and($client->versioned()->api()->container()->attachWebsocket('abc'))->toBeInstanceOf(StreamResponse::class)
        ->and($transport->requests[1]->headers['Upgrade'])->toBe('websocket')
        ->and($transport->requests[1]->headers['Sec-WebSocket-Version'])->toBe('13')
        ->and(mb_strlen((string) base64_decode($transport->requests[1]->headers['Sec-WebSocket-Key'], true), '8bit'))->toBe(16);
});
