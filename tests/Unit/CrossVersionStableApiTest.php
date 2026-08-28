<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Tests\Support\FakeDockerTransport;
use Misaf\DockerEngine\Transport\Response;

it('normalizes representative API versions to equivalent stable resource semantics', function (ApiVersion $version, array $responses): void {
    $transport = new FakeDockerTransport()->queue(...array_map(
        static fn(array $body): Response => new Response(200, [], json_encode($body, JSON_THROW_ON_ERROR)),
        $responses,
    ));
    $client = new DockerClient($transport, $version);

    $container = $client->containers()->list()[0];
    $inspect = $client->containers()->inspect('container-id');
    $image = $client->images()->list()[0];
    $network = $client->networks()->list()[0];
    $volume = $client->volumes()->list()[0];
    $engineVersion = $client->system()->version();
    $engineInfo = $client->system()->info();

    expect([
        'container' => [$container->id->value, $container->names, $container->image, $container->state, $container->labels],
        'inspect'   => [$inspect->id->value, $inspect->name, $inspect->image, $inspect->state, $inspect->running],
        'image'     => [$image->id, $image->repoTags, $image->repoDigests, $image->created, $image->size],
        'network'   => [$network->id->value, $network->name, $network->driver, $network->scope, $network->labels],
        'volume'    => [$volume->name->value, $volume->driver, $volume->mountpoint, $volume->scope, $volume->labels],
        'version'   => [$engineVersion->version, $engineVersion->apiVersion, $engineVersion->minimumApiVersion],
        'info'      => [$engineInfo->id, $engineInfo->name, $engineInfo->containers, $engineInfo->containersRunning, $engineInfo->images, $engineInfo->labels],
    ])->toBe(stableSemantics());

    foreach ($transport->requests as $request) {
        expect($request->target())->toStartWith('/v' . $version->value . '/');
    }
})->with([
    'minimum v1.40 with absent optional fields' => [ApiVersion::V1_40, stableResponses(ApiVersion::V1_40, false)],
    'middle v1.44 with explicit null optionals' => [ApiVersion::V1_44, stableResponses(ApiVersion::V1_44, true)],
    'v1.50 generated inspect schema boundary'   => [ApiVersion::V1_50, stableResponses(ApiVersion::V1_50, false)],
    'maximum v1.55 with added fields'           => [ApiVersion::V1_55, stableResponses(ApiVersion::V1_55, true, true)],
]);

/** @return array<string, list<mixed>> */
function stableSemantics(): array
{
    return [
        'container' => ['container-id', [], 'alpine', 'running', []],
        'inspect'   => ['container-id', '/stable', 'alpine', 'running', true],
        'image'     => ['sha256:image', [], [], 1_700_000_000, 42],
        'network'   => ['network-id', 'stable-network', 'bridge', 'local', []],
        'volume'    => ['stable-volume', 'local', '/data', 'local', []],
        'version'   => ['engine-version', 'api-version', '1.40'],
        'info'      => ['engine-id', 'engine-name', 2, 1, 3, []],
    ];
}

/** @return list<array<array-key, mixed>> */
function stableResponses(ApiVersion $version, bool $explicitNull, bool $newFields = false): array
{
    $optional = $explicitNull ? null : [];
    $extra = $newFields ? ['Descriptor' => ['digest' => 'ignored'], 'ImageManifestDescriptor' => ['digest' => 'ignored']] : [];

    return [
        [[
            'Id' => 'container-id', 'Image' => 'alpine', 'State' => 'running', 'Status' => 'Up',
            ...($explicitNull ? ['Names' => null, 'Labels' => null] : []), ...$extra,
        ]],
        ['Id' => 'container-id', 'Name' => '/stable', 'Config' => ['Image' => 'alpine'], 'HostConfig' => [], 'State' => ['Status' => 'running', 'Running' => true], ...$extra],
        [['Id' => 'sha256:image', 'RepoTags' => $optional, 'RepoDigests' => $optional, 'Created' => 1_700_000_000, 'Size' => 42, ...$extra]],
        [['Id' => 'network-id', 'Name' => 'stable-network', 'Driver' => 'bridge', 'Scope' => 'local', 'Labels' => $optional, ...$extra]],
        ['Volumes' => [['Name' => 'stable-volume', 'Driver' => 'local', 'Mountpoint' => '/data', 'Scope' => 'local', 'Labels' => $optional, ...$extra]], 'Warnings' => $optional],
        ['Version' => 'engine-version', 'ApiVersion' => 'api-version', 'MinAPIVersion' => '1.40', 'Os' => 'linux', 'Arch' => 'amd64', ...$extra],
        ['ID'      => 'engine-id', 'Name' => 'engine-name', 'Containers' => 2, 'ContainersRunning' => 1, 'Images' => 3, 'Labels' => $optional, 'OperatingSystem' => 'Linux', 'Architecture' => 'x86_64', 'ApiVersionSeen' => $version->value, ...$extra],
    ];
}
