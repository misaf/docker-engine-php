<?php

declare(strict_types=1);

use Misaf\DockerEngine\Api\V1_55\ApiSet;
use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Dto\Container\CreateContainer;
use Misaf\DockerEngine\Dto\Container\CreatedContainer;
use Misaf\DockerEngine\Dto\System\EngineInfo;
use Misaf\DockerEngine\Dto\System\EngineVersion;
use Misaf\DockerEngine\Engine\EngineImplementation;
use Misaf\DockerEngine\Tests\Support\FakeDockerTransport;
use Misaf\DockerEngine\Transport\ResourceStream;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;

it('returns stable container DTOs independent of the negotiated generated namespace', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], json_encode([
        ['Id' => 'abc', 'Names' => ['/web'], 'Image' => 'nginx', 'State' => 'running', 'Status' => 'Up', 'Labels' => ['app' => 'web']],
    ], JSON_THROW_ON_ERROR)));

    $containers = (new DockerClient($transport, ApiVersion::V1_40))->containers()->list();

    expect($containers[0]->id->value)->toBe('abc')
        ->and($containers[0]->names)->toBe(['/web'])
        ->and($containers[0]->labels)->toBe(['app' => 'web'])
        ->and($transport->requests[0]->target())->toBe('/v1.40/containers/json?all=false&size=false');
});

it('creates a container from a normalized stable request', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(201, [], '{"Id":"created","Warnings":[]}'));
    $created = (new DockerClient($transport, ApiVersion::V1_55))->containers()->create(new CreateContainer(
        image: 'nginx:latest',
        name: 'web',
        command: ['nginx', '-g', 'daemon off;'],
        environment: ['APP_ENV' => 'test'],
    ));

    expect($created)->toBeInstanceOf(CreatedContainer::class)
        ->and($created->id->value)->toBe('created')
        ->and($transport->requests[0]->body)->toMatchArray([
            'Image' => 'nginx:latest',
            'Cmd'   => ['nginx', '-g', 'daemon off;'],
            'Env'   => ['APP_ENV=test'],
        ]);
});

it('keeps exact generated APIs behind the explicit versioned gateway', function (): void {
    $client = new DockerClient(new FakeDockerTransport(), ApiVersion::V1_55);

    expect($client->versioned()->api())->toBeInstanceOf(ApiSet::class)
        ->and($client->swarm())->toBe($client->versioned()->api()->swarm());
});

it('maps stable system responses and derives a small engine capability extension point', function (): void {
    $transport = new FakeDockerTransport()->queue(
        new Response(200, [], '{"Version":"29.0","ApiVersion":"1.55","MinAPIVersion":"1.40","Os":"linux","Arch":"amd64"}'),
        new Response(200, [], '{"ID":"engine","Name":"host","Containers":2,"ContainersRunning":1,"Images":3,"OperatingSystem":"Linux","Architecture":"x86_64"}'),
        new Response(200, [], '{"Version":"5.5.0","ApiVersion":"1.41","Platform":{"Name":"Podman Engine"}}'),
        new Response(200, [], '{"ServerVersion":"5.5.0","OperatingSystem":"Podman","Containers":0,"Images":0}'),
    );
    $client = new DockerClient($transport, ApiVersion::V1_41);

    expect($client->system()->version())->toBeInstanceOf(EngineVersion::class)
        ->and($client->system()->info())->toBeInstanceOf(EngineInfo::class)
        ->and($client->capabilities()->implementation)->toBe(EngineImplementation::Podman)
        ->and($client->capabilities()->supportsSwarm)->toBeFalse();
});

it('maps errors returned before a raw stream begins', function (): void {
    $transport = new FakeDockerTransport()->queue(new StreamResponse(
        404,
        ['Content-Type' => ['application/json']],
        ResourceStream::memory('{"message":"stream missing"}'),
    ));

    expect(fn() => (new DockerClient($transport, ApiVersion::V1_55))->raw()->stream('GET', '/missing'))
        ->toThrow(Misaf\DockerEngine\Exceptions\NotFoundException::class, 'stream missing');
});
