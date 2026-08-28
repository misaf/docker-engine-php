<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_47\Task\Responses;

final readonly class TaskListResponse
{
    /** @param list<\Misaf\DockerEngine\Api\V1_47\Schemas\Task> $items */
    public function __construct(
        #[\Misaf\DockerEngine\Serialization\ArrayOf(\Misaf\DockerEngine\Api\V1_47\Schemas\Task::class)]
        public array $items,
    ) {}
}
