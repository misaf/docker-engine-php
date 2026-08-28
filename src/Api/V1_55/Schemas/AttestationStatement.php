<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** AttestationStatement is a single in-toto statement attached to an image. */
readonly class AttestationStatement
{
    /**
     * @param OCIDescriptor $descriptor
     * @param array<string, mixed>|Undefined $statement
     */
    public function __construct(
        #[SerializedName('Descriptor')]
        public OCIDescriptor $descriptor,
        #[SerializedName('PredicateType')]
        public string $predicateType,
        #[SerializedName('Statement')]
        public array|Undefined|null $statement = Undefined::Value,
    ) {}
}
