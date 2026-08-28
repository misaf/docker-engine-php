<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

use BackedEnum;
use Misaf\DockerEngine\Contracts\Serializer;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Serialization\Undefined;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use Stringable;

abstract readonly class GeneratedRequest
{
    /**
     * @return array{path: array<string, scalar>, query: array<string, scalar|list<scalar>|null>, headers: array<string, string>, body: string|object|Stream|array<array-key, mixed>|null}
     */
    final public function parts(Serializer $serializer): array
    {
        $path = [];
        $query = [];
        $headers = [];
        $body = null;
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $attributes = $property->getAttributes(RequestParameter::class, ReflectionAttribute::IS_INSTANCEOF);

            if ([] === $attributes || ! $property->isInitialized($this)) {
                continue;
            }

            $value = $property->getValue($this);

            if (Undefined::Value === $value) {
                continue;
            }

            /** @var RequestParameter $parameter */
            $parameter = $attributes[0]->newInstance();

            if ('body' === $parameter->location) {
                if ($value instanceof Stream) {
                    $body = $value;
                } elseif (is_object($value)) {
                    $body = $serializer->normalize($value);
                } elseif (is_string($value) || is_array($value) || null === $value) {
                    $body = $value;
                }

                continue;
            }

            $value = self::scalarize($value);

            if ('path' === $parameter->location && is_scalar($value)) {
                $path[$parameter->name] = $value;
            } elseif ('query' === $parameter->location && (is_scalar($value) || null === $value)) {
                $query[$parameter->name] = $value;
            } elseif ('query' === $parameter->location && is_array($value)) {
                $items = [];

                foreach ($value as $item) {
                    if (is_scalar($item)) {
                        $items[] = $item;
                    }
                }

                $query[$parameter->name] = $items;
            } elseif ('header' === $parameter->location && is_scalar($value)) {
                $headers[$parameter->name] = (string) $value;
            }
        }

        return compact('path', 'query', 'headers', 'body');
    }

    private static function scalarize(mixed $value): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof Stringable) {
            return (string) $value;
        }

        if (is_array($value)) {
            return array_map(self::scalarize(...), $value);
        }

        return $value;
    }
}
