<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_50\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class ProcessConfig
{
    /**
     * @param list<string>|Undefined $arguments
     */
    public function __construct(
        #[SerializedName('privileged')]
        public bool|Undefined $privileged = Undefined::Value,
        #[SerializedName('user')]
        public string|Undefined $user = Undefined::Value,
        #[SerializedName('tty')]
        public bool|Undefined $tty = Undefined::Value,
        #[SerializedName('entrypoint')]
        public string|Undefined $entrypoint = Undefined::Value,
        #[SerializedName('arguments')]
        public array|Undefined $arguments = Undefined::Value,
    ) {}
}
