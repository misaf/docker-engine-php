<?php

declare(strict_types=1);

namespace Misaf\DockerEngine;

use Misaf\DockerEngine\Exceptions\UnsupportedApiVersionException;

enum ApiVersion: string
{
    case V1_40 = '1.40';
    case V1_41 = '1.41';
    case V1_42 = '1.42';
    case V1_43 = '1.43';
    case V1_44 = '1.44';
    case V1_45 = '1.45';
    case V1_46 = '1.46';
    case V1_47 = '1.47';
    case V1_48 = '1.48';
    case V1_49 = '1.49';
    case V1_50 = '1.50';
    case V1_51 = '1.51';
    case V1_52 = '1.52';
    case V1_53 = '1.53';
    case V1_54 = '1.54';
    case V1_55 = '1.55';

    public static function minimum(): self
    {
        return self::V1_40;
    }

    public static function latest(): self
    {
        return self::V1_55;
    }

    public static function parse(string $version): self
    {
        $normalized = mb_ltrim(mb_trim($version), 'vV');

        return self::tryFrom($normalized)
            ?? throw UnsupportedApiVersionException::requested($normalized);
    }

    /** @return list<self> */
    public static function supported(): array
    {
        return self::cases();
    }

    public function pathPrefix(): string
    {
        return '/v' . $this->value;
    }

    public function isAtLeast(self $other): bool
    {
        return version_compare($this->value, $other->value, '>=');
    }

    public function isBefore(self $other): bool
    {
        return version_compare($this->value, $other->value, '<');
    }
}
