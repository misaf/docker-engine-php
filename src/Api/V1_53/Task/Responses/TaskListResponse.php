<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Task\Responses;

final readonly class TaskListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_53\Schemas\Task> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_53\Schemas\Task::class)]
        public array $items,
    ) {}
}
