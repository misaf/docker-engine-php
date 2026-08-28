<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Serialization;

use Misaf\DockerEngine\Contracts\Serializer as SerializerContract;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;

final readonly class SymfonySerializer implements SerializerContract
{
    private NormalizerInterface&DenormalizerInterface $serializer;

    public function __construct((NormalizerInterface&DenormalizerInterface)|null $serializer = null)
    {
        $this->serializer = $serializer ?? new Serializer([new DockerDtoNormalizer()]);
    }

    public function normalize(object $value): array
    {
        try {
            $normalized = $this->serializer->normalize($value);
        } catch (ExceptionInterface $exception) {
            throw new InvalidResponseException('Unable to normalize Docker DTO: ' . $exception->getMessage(), previous: $exception);
        }

        if ( ! is_array($normalized)) {
            throw new InvalidResponseException('Docker DTO normalization did not produce an array.');
        }

        return $normalized;
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T
     */
    public function denormalize(array $data, string $class): object
    {
        try {
            $value = $this->serializer->denormalize($data, $class);
        } catch (ExceptionInterface $exception) {
            throw new InvalidResponseException('Unable to hydrate Docker DTO: ' . $exception->getMessage(), previous: $exception);
        }

        if ( ! $value instanceof $class) {
            throw new InvalidResponseException('Docker DTO hydration did not produce an object.');
        }

        return $value;
    }
}
