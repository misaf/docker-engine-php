<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
final readonly class RequestParameter
{
    public function __construct(
        public string $name,
        public string $location,
        public bool $repeated = false,
    ) {}
}
