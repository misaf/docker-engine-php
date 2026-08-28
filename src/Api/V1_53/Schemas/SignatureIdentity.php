<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

use Misaf\DockerEngine\Serialization\ArrayOf;
use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** SignatureIdentity contains the properties of verified signatures for the image. */
readonly class SignatureIdentity
{
    /**
     * @param list<SignatureTimestamp>|Undefined $timestamps
     * @param KnownSignerIdentity|Undefined $knownSigner
     * @param SignerIdentity|Undefined $signer
     * @param SignatureType|Undefined $signatureType
     * @param list<string>|Undefined $warnings
     */
    public function __construct(
        #[SerializedName('Name')]
        public string|Undefined $name = Undefined::Value,
        #[SerializedName('Timestamps')]
        #[ArrayOf(SignatureTimestamp::class)]
        public array|Undefined $timestamps = Undefined::Value,
        #[SerializedName('KnownSigner')]
        public KnownSignerIdentity|Undefined $knownSigner = Undefined::Value,
        #[SerializedName('DockerReference')]
        public string|Undefined $dockerReference = Undefined::Value,
        #[SerializedName('Signer')]
        public SignerIdentity|Undefined $signer = Undefined::Value,
        #[SerializedName('SignatureType')]
        public SignatureType|Undefined $signatureType = Undefined::Value,
        #[SerializedName('Error')]
        public string|Undefined $error = Undefined::Value,
        #[SerializedName('Warnings')]
        public array|Undefined $warnings = Undefined::Value,
    ) {}
}
