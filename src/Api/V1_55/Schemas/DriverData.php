<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the storage driver used to store the container's and */
readonly class DriverData
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        #[SerializedName('Name')]
        public string $name,
        #[SerializedName('Data')]
        public array $data,
    ) {}
}
