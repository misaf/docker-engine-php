<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

interface Serializer
{
    /** @return array<array-key, mixed> */
    public function normalize(object $value): array;

    /**
     * @template T of object
     * @param class-string<T> $class
     * @param array<array-key, mixed> $data
     * @return T
     */
    public function denormalize(array $data, string $class): object;
}
