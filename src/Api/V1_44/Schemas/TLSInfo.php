<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Information about the issuer of leaf TLS certificates and the trusted root */
readonly class TLSInfo
{
    public function __construct(
        #[SerializedName('TrustRoot')]
        public string|Undefined $trustRoot = Undefined::Value,
        #[SerializedName('CertIssuerSubject')]
        public string|Undefined $certIssuerSubject = Undefined::Value,
        #[SerializedName('CertIssuerPublicKey')]
        public string|Undefined $certIssuerPublicKey = Undefined::Value,
    ) {}
}
