<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

/**
 * Deliberate gateway to the exact OpenAPI-generated API selected by negotiation.
 *
 * Consumers using this layer accept version-specific request and response DTOs.
 */
final readonly class VersionedApi
{
    public function __construct(private Api\V1_40\ApiSet
        |Api\V1_41\ApiSet
        |Api\V1_42\ApiSet
        |Api\V1_43\ApiSet
        |Api\V1_44\ApiSet
        |Api\V1_45\ApiSet
        |Api\V1_46\ApiSet
        |Api\V1_47\ApiSet
        |Api\V1_48\ApiSet
        |Api\V1_49\ApiSet
        |Api\V1_50\ApiSet
        |Api\V1_51\ApiSet
        |Api\V1_52\ApiSet
        |Api\V1_53\ApiSet
        |Api\V1_54\ApiSet
        |Api\V1_55\ApiSet $api) {}

    public function api(): Api\V1_40\ApiSet
    |Api\V1_41\ApiSet
    |Api\V1_42\ApiSet
    |Api\V1_43\ApiSet
    |Api\V1_44\ApiSet
    |Api\V1_45\ApiSet
    |Api\V1_46\ApiSet
    |Api\V1_47\ApiSet
    |Api\V1_48\ApiSet
    |Api\V1_49\ApiSet
    |Api\V1_50\ApiSet
    |Api\V1_51\ApiSet
    |Api\V1_52\ApiSet
    |Api\V1_53\ApiSet
    |Api\V1_54\ApiSet
    |Api\V1_55\ApiSet
    {
        return $this->api;
    }
}
