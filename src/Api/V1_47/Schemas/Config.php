<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Config
{
    /**
     * @param ObjectVersion|Undefined $version
     * @param ConfigSpec|Undefined $spec
     */
    public function __construct(
        #[SerializedName('ID')]
        public string|Undefined $id = Undefined::Value,
        #[SerializedName('Version')]
        public ObjectVersion|Undefined $version = Undefined::Value,
        #[SerializedName('CreatedAt')]
        public string|Undefined $createdAt = Undefined::Value,
        #[SerializedName('UpdatedAt')]
        public string|Undefined $updatedAt = Undefined::Value,
        #[SerializedName('Spec')]
        public ConfigSpec|Undefined $spec = Undefined::Value,
    ) {}
}
