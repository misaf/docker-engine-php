<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Available plugins per type. */
readonly class PluginsInfo
{
    /**
     * @param list<string>|Undefined $volume
     * @param list<string>|Undefined $network
     * @param list<string>|Undefined $authorization
     * @param list<string>|Undefined $log
     */
    public function __construct(
        #[SerializedName('Volume')]
        public array|Undefined $volume = Undefined::Value,
        #[SerializedName('Network')]
        public array|Undefined $network = Undefined::Value,
        #[SerializedName('Authorization')]
        public array|Undefined $authorization = Undefined::Value,
        #[SerializedName('Log')]
        public array|Undefined $log = Undefined::Value,
    ) {}
}
