<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_45\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class EndpointPortConfig
{
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Protocol')]
        public string|Undefined $protocol = Undefined::Value,
        #[SerializedName('TargetPort')]
        public int|Undefined $targetPort = Undefined::Value,
        #[SerializedName('PublishedPort')]
        public int|Undefined $publishedPort = Undefined::Value,
        #[SerializedName('PublishMode')]
        public string|Undefined $publishMode = Undefined::Value,
    ) {}
}
