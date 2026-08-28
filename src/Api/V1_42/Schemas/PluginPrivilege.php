<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_42\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Describes a permission the user has to accept upon installing */
readonly class PluginPrivilege
{
    /**
     * @param list<string>|Undefined $value
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Description')]
        public string|Undefined $description = Undefined::Value,
        #[SerializedName('Value')]
        public array|Undefined $value = Undefined::Value,
    ) {}
}
