<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

final readonly class TlsOptions
{
    public function __construct(
        public ?string $ca = null,
        public ?string $certificate = null,
        public ?string $privateKey = null,
        public ?string $privateKeyPassword = null,
        public bool $verifyPeer = true,
        public bool $verifyHost = true,
    ) {}
}
