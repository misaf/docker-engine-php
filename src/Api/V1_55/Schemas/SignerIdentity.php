<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** SignerIdentity contains information about the signer certificate used to sign the image. */
readonly class SignerIdentity
{
    public function __construct(
        #[SerializedName('CertificateIssuer')]
        public string|Undefined $certificateIssuer = Undefined::Value,
        #[SerializedName('SubjectAlternativeName')]
        public string|Undefined $subjectAlternativeName = Undefined::Value,
        #[SerializedName('Issuer')]
        public string|Undefined $issuer = Undefined::Value,
        #[SerializedName('BuildSignerURI')]
        public string|Undefined $buildSignerUri = Undefined::Value,
        #[SerializedName('BuildSignerDigest')]
        public string|Undefined $buildSignerDigest = Undefined::Value,
        #[SerializedName('RunnerEnvironment')]
        public string|Undefined $runnerEnvironment = Undefined::Value,
        #[SerializedName('SourceRepositoryURI')]
        public string|Undefined $sourceRepositoryUri = Undefined::Value,
        #[SerializedName('SourceRepositoryDigest')]
        public string|Undefined $sourceRepositoryDigest = Undefined::Value,
        #[SerializedName('SourceRepositoryRef')]
        public string|Undefined $sourceRepositoryRef = Undefined::Value,
        #[SerializedName('SourceRepositoryIdentifier')]
        public string|Undefined $sourceRepositoryIdentifier = Undefined::Value,
        #[SerializedName('SourceRepositoryOwnerURI')]
        public string|Undefined $sourceRepositoryOwnerUri = Undefined::Value,
        #[SerializedName('SourceRepositoryOwnerIdentifier')]
        public string|Undefined $sourceRepositoryOwnerIdentifier = Undefined::Value,
        #[SerializedName('BuildConfigURI')]
        public string|Undefined $buildConfigUri = Undefined::Value,
        #[SerializedName('BuildConfigDigest')]
        public string|Undefined $buildConfigDigest = Undefined::Value,
        #[SerializedName('BuildTrigger')]
        public string|Undefined $buildTrigger = Undefined::Value,
        #[SerializedName('RunInvocationURI')]
        public string|Undefined $runInvocationUri = Undefined::Value,
        #[SerializedName('SourceRepositoryVisibilityAtSigning')]
        public string|Undefined $sourceRepositoryVisibilityAtSigning = Undefined::Value,
    ) {}
}
