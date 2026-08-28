<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_49\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

readonly class Mount
{
    /**
     * @param MountType|Undefined $type
     * @param array<string, mixed>|Undefined $bindOptions
     * @param array<string, mixed>|Undefined $volumeOptions
     * @param array<string, mixed>|Undefined $imageOptions
     * @param array<string, mixed>|Undefined $tmpfsOptions
     */
    public function __construct(
        #[SerializedName('Target')]
        public string|Undefined $target = Undefined::Value,
        #[SerializedName('Source')]
        public string|Undefined $source = Undefined::Value,
        #[SerializedName('Type')]
        public MountType|Undefined $type = Undefined::Value,
        #[SerializedName('ReadOnly')]
        public bool|Undefined $readOnly = Undefined::Value,
        #[SerializedName('Consistency')]
        public string|Undefined $consistency = Undefined::Value,
        #[SerializedName('BindOptions')]
        public array|Undefined $bindOptions = Undefined::Value,
        #[SerializedName('VolumeOptions')]
        public array|Undefined $volumeOptions = Undefined::Value,
        #[SerializedName('ImageOptions')]
        public array|Undefined $imageOptions = Undefined::Value,
        #[SerializedName('TmpfsOptions')]
        public array|Undefined $tmpfsOptions = Undefined::Value,
    ) {}
}
