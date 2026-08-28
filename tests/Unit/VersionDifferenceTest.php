<?php

declare(strict_types=1);

use Misaf\DockerEngine\Api\V1_49\Schemas\ImageConfig as ImageConfigV1_49;
use Misaf\DockerEngine\Api\V1_50\Schemas\ImageConfig as ImageConfigV1_50;

it('preserves a real v1.49 to v1.50 schema change', function (): void {
    expect((new ReflectionClass(ImageConfigV1_49::class))->hasProperty('hostname'))->toBeTrue()
        ->and((new ReflectionClass(ImageConfigV1_50::class))->hasProperty('hostname'))->toBeFalse();
});

it('adds the image attestations operation only in v1.55', function (): void {
    expect(method_exists(Misaf\DockerEngine\Api\V1_54\Image\ImageApi::class, 'attestations'))->toBeFalse()
        ->and(method_exists(Misaf\DockerEngine\Api\V1_55\Image\ImageApi::class, 'attestations'))->toBeTrue();
});
