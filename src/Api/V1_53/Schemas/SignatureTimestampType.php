<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

/** SignatureTimestampType is the type of timestamp used in the signature. */
enum SignatureTimestampType: string
{
    case Tlog = 'Tlog';
    case TimestampAuthority = 'TimestampAuthority';
}
