<?php

declare(strict_types=1);

use Misaf\DockerEngine\Api\V1_55\Schemas\ContainerSummary;
use Misaf\DockerEngine\Serialization\SymfonySerializer;
use Misaf\DockerEngine\Serialization\Undefined;

it('distinguishes missing, null, false, zero, empty array, and empty string', function (): void {
    $serializer = new SymfonySerializer();
    $summary = $serializer->denormalize([
        'Id'         => '',
        'Created'    => 0,
        'SizeRw'     => null,
        'Labels'     => [],
        'HostConfig' => ['ReadonlyRootfs' => false],
    ], ContainerSummary::class);

    expect($summary)->toBeInstanceOf(ContainerSummary::class)
        ->and($summary->id)->toBe('')
        ->and($summary->created)->toBe(0)
        ->and($summary->sizeRw)->toBeNull()
        ->and($summary->labels)->toBe([])
        ->and($summary->status)->toBe(Undefined::Value)
        ->and($serializer->normalize($summary))->not->toHaveKey('Status')
        ->and($serializer->normalize($summary)['HostConfig'])->toBe(['ReadonlyRootfs' => false]);
});
