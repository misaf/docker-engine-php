<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_51\Schemas;

use Misaf\DockerEngine\Serialization\Undefined;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** Specifies how a task is attached to a network, and the addresses the */
readonly class NetworkAttachment
{
    /**
     * @param Network|Undefined $network
     * @param list<string>|Undefined $addresses
     */
    public function __construct(
        #[SerializedName('Network')]
        public Network|Undefined $network = Undefined::Value,
        #[SerializedName('Addresses')]
        public array|Undefined $addresses = Undefined::Value,
    ) {}
}
