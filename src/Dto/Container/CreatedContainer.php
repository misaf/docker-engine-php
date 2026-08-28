<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

use Misaf\DockerEngine\ValueObjects\ContainerId;

final readonly class CreatedContainer
{
    /** @param list<string> $warnings */
    public function __construct(public ContainerId $id, public array $warnings = []) {}
}
