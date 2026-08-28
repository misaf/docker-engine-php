<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Exceptions\UnsupportedApiVersionException;
use Misaf\DockerEngine\Exceptions\VersionNegotiationException;
use Misaf\DockerEngine\Tests\Support\FakeDockerTransport;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\VersionNegotiator;

it('selects the highest common daemon and SDK version', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], json_encode([
        'ApiVersion'    => '1.53',
        'MinAPIVersion' => '1.42',
    ], JSON_THROW_ON_ERROR)));

    expect((new VersionNegotiator($transport))->negotiate())->toBe(ApiVersion::V1_53)
        ->and($transport->requests[0]->target())->toBe('/version');
});

it('caps a newer daemon at the SDK maximum', function (): void {
    $transport = new FakeDockerTransport()->queue(new Response(200, [], '{"ApiVersion":"1.56","MinAPIVersion":"1.40"}'));

    expect((new VersionNegotiator($transport))->negotiate())->toBe(ApiVersion::V1_55);
});

it('rejects disjoint and malformed daemon ranges', function (): void {
    $disjoint = new FakeDockerTransport()->queue(new Response(200, [], '{"ApiVersion":"1.39","MinAPIVersion":"1.24"}'));
    $malformed = new FakeDockerTransport()->queue(new Response(200, [], '{"Version":"old"}'));

    expect(fn(): ApiVersion => (new VersionNegotiator($disjoint))->negotiate())
        ->toThrow(UnsupportedApiVersionException::class)
        ->and(fn(): ApiVersion => (new VersionNegotiator($malformed))->negotiate())
        ->toThrow(VersionNegotiationException::class);
});
