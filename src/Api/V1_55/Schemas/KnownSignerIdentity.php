<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_55\Schemas;

/** KnownSignerIdentity is an identifier for a special signer identity that is known to the implementation. */
enum KnownSignerIdentity: string
{
    case DHI = 'DHI';
}
