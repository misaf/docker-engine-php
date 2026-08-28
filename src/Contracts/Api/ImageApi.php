<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts\Api;

use Misaf\DockerEngine\Dto\Image\ImageSummary;
use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\ValueObjects\ImageReference;

interface ImageApi
{
    /** @return list<ImageSummary> */
    public function list(bool $all = false): array;

    public function pull(ImageReference|string $image, ?string $registryAuth = null): ProgressStream;
}
