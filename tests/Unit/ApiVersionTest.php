<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Exceptions\UnsupportedApiVersionException;

it('represents the explicit supported API range', function (): void {
    expect(ApiVersion::supported())->toHaveCount(16)
        ->and(ApiVersion::minimum())->toBe(ApiVersion::V1_40)
        ->and(ApiVersion::latest())->toBe(ApiVersion::V1_55)
        ->and(ApiVersion::V1_55->pathPrefix())->toBe('/v1.55');
});

it('compares and parses versions without scattered string comparisons', function (): void {
    expect(ApiVersion::V1_50->isAtLeast(ApiVersion::V1_49))->toBeTrue()
        ->and(ApiVersion::V1_50->isBefore(ApiVersion::V1_55))->toBeTrue()
        ->and(ApiVersion::parse('v1.43'))->toBe(ApiVersion::V1_43)
        ->and(fn(): ApiVersion => ApiVersion::parse('1.56'))->toThrow(UnsupportedApiVersionException::class);
});
