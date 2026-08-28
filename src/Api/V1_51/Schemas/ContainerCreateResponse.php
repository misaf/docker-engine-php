<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** OK response to ContainerCreate operation */
readonly class ContainerCreateResponse
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
