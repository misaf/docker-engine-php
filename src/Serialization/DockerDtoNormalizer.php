<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Serialization;

use BackedEnum;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionUnionType;
use Stringable;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Symfony Serializer bridge for generated Docker DTOs.
 *
 * The small amount of custom behavior is protocol-owned: Docker distinguishes
 * an absent field from null, and generated collection element types come from
 * OpenAPI rather than runtime PHP reflection.
 */
final class DockerDtoNormalizer implements NormalizerInterface, DenormalizerInterface, NormalizerAwareInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function normalize(mixed $data, ?string $format = null, array $context = []): array
    {
        if (! is_object($data)) {
            throw new InvalidResponseException('Docker DTO normalization requires an object.');
        }

        $result = [];
        $reflection = new ReflectionClass($data);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (! $property->isInitialized($data)) {
                continue;
            }

            $value = $property->getValue($data);

            if (Undefined::Value === $value) {
                continue;
            }

            $result[$this->wireName($property)] = $this->normalizeValue($value, $format, $context);
        }

        return $result;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return is_object($data) && ! $data instanceof BackedEnum && ! $data instanceof Stringable;
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): object
    {
        if (! is_array($data)) {
            throw new InvalidResponseException(sprintf('Docker response for %s must be an object.', $type));
        }

        if (! class_exists($type)) {
            throw new InvalidResponseException('Unknown Docker DTO class ' . $type . '.');
        }

        $reflection = new ReflectionClass($type);
        $constructor = $reflection->getConstructor();

        if (null === $constructor) {
            return $reflection->newInstance();
        }

        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            $wireName = $this->wireName($reflection->getProperty($parameter->getName()));

            if (! array_key_exists($wireName, $data)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $arguments[] = $parameter->getDefaultValue();

                    continue;
                }

                throw new InvalidResponseException(sprintf('Docker response is missing required field %s for %s.', $wireName, $type));
            }

            $arguments[] = $this->denormalizeValue($data[$wireName], $parameter, $format, $context);
        }

        return $reflection->newInstanceArgs($arguments);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_array($data) && class_exists($type) && ! enum_exists($type);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['object' => false];
    }

    /** @param array<string, mixed> $context */
    private function normalizeValue(mixed $value, ?string $format, array $context): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof Stringable) {
            return (string) $value;
        }

        if (is_array($value)) {
            return array_map(fn(mixed $item): mixed => $this->normalizeValue($item, $format, $context), $value);
        }

        if (is_object($value)) {
            return $this->normalizer->normalize($value, $format, $context);
        }

        return $value;
    }

    /** @param array<string, mixed> $context */
    private function denormalizeValue(mixed $value, ReflectionParameter $parameter, ?string $format, array $context): mixed
    {
        if (null === $value) {
            return null;
        }

        $arrayOf = $parameter->getAttributes(ArrayOf::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

        if (null !== $arrayOf && is_array($value)) {
            /** @var ArrayOf $attribute */
            $attribute = $arrayOf->newInstance();

            return array_map(fn(mixed $item): mixed => is_array($item)
                ? $this->denormalizer->denormalize($item, $attribute->class, $format, $context)
                : $item, $value);
        }

        foreach ($this->typeNames($parameter) as $name) {
            if (enum_exists($name) && is_subclass_of($name, BackedEnum::class) && (is_string($value) || is_int($value))) {
                /** @var class-string<BackedEnum> $name */
                return $name::from($value);
            }

            if (Undefined::class !== $name && class_exists($name) && is_array($value)) {
                return $this->denormalizer->denormalize($value, $name, $format, $context);
            }
        }

        return $value;
    }

    /** @return list<string> */
    private function typeNames(ReflectionParameter $parameter): array
    {
        $type = $parameter->getType();

        if ($type instanceof ReflectionNamedType) {
            return [$type->getName()];
        }

        if ($type instanceof ReflectionUnionType) {
            $names = [];

            foreach ($type->getTypes() as $member) {
                if ($member instanceof ReflectionNamedType) {
                    $names[] = $member->getName();
                }
            }

            return $names;
        }

        return [];
    }

    private function wireName(ReflectionProperty $property): string
    {
        $attribute = $property->getAttributes(SerializedName::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

        if (null === $attribute) {
            return $property->getName();
        }

        /** @var SerializedName $name */
        $name = $attribute->newInstance();

        return $name->serializedName;
    }
}
