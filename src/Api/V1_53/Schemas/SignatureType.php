<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_53\Schemas;

/** SignatureType is the type of signature format. */
enum SignatureType: string
{
    case BundleV03 = 'bundle-v0.3';
    case SimplesigningV1 = 'simplesigning-v1';
}
