<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Image\Responses;

final readonly class ImageAttestationsResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_55\Schemas\AttestationStatement> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_55\Schemas\AttestationStatement::class)]
        public array $items,
    ) {}
}
