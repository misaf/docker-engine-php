<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_41\Container\Responses;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** Create a container */
final readonly class ContainerCreateResponse
{
    /**
     * @param list<string> $warnings
     */
    public function __construct(
        #[SerializedName('Id')]
        public string $id,
        #[SerializedName('Warnings')]
        public array $warnings,
    ) {}
}
