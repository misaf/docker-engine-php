<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\Exceptions\UnsupportedApiVersionException;
use Misaf\DockerEngine\Exceptions\VersionNegotiationException;
use Misaf\DockerEngine\Transport\Request;

final readonly class VersionNegotiator
{
    public function __construct(
        private Transport $transport,
        private ErrorMapper $errors = new ErrorMapper(),
    ) {}

    public function negotiate(): ApiVersion
    {
        $response = $this->transport->request(new Request('GET', '/version'));

        if (! $response->successful()) {
            throw new VersionNegotiationException(
                'Docker API version negotiation failed: ' . $this->errors->exception($response)->getMessage(),
            );
        }

        $data = $response->json();
        $maximum = $data['ApiVersion'] ?? null;
        $minimum = $data['MinAPIVersion'] ?? null;

        if (! is_string($maximum) || '' === $maximum) {
            throw new VersionNegotiationException('Docker /version response did not contain ApiVersion.');
        }

        if (! is_string($minimum) || '' === $minimum) {
            throw new VersionNegotiationException('Docker /version response did not contain MinAPIVersion.');
        }

        $compatible = array_values(array_filter(
            ApiVersion::supported(),
            static fn(ApiVersion $version): bool => version_compare($version->value, $minimum, '>=')
                && version_compare($version->value, $maximum, '<='),
        ));

        return end($compatible) ?: throw UnsupportedApiVersionException::noOverlap($minimum, $maximum);
    }
}
