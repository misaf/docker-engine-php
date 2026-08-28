<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

final readonly class ProgressEvent
{
    /**
     * @param array<array-key, mixed>|null $progressDetail
     * @param array<array-key, mixed>|null $errorDetail
     * @param array<array-key, mixed>|null $aux
     */
    public function __construct(
        public ?string $status = null,
        public ?string $id = null,
        public ?string $progress = null,
        public ?array $progressDetail = null,
        public ?string $error = null,
        public ?array $errorDetail = null,
        public ?array $aux = null,
    ) {}
}
