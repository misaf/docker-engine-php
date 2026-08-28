<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

final readonly class ListContainers
{
    /** @param array<string, list<string>> $filters */
    public function __construct(
        public bool $all = false,
        public ?int $limit = null,
        public bool $includeSize = false,
        public array $filters = [],
    ) {}
}
