<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Serialization;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
final readonly class ArrayOf
{
    /** @param class-string $class */
    public function __construct(public string $class) {}
}
