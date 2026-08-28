<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Cli\Helper;

use Misaf\DockerEngine\Serialization\Undefined;

final class Render
{
    /** Render any DTO value as a flat string, treating Undefined as empty. */
    public static function value(mixed $value): string
    {
        if ($value instanceof Undefined) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_array($value)) {
            return implode(', ', array_map(self::value(...), $value));
        }

        if (null === $value) {
            return '';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        return '';
    }

    public static function bytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $index = 0;
        $size = (float) $bytes;

        while ($size >= 1024 && $index < count($units) - 1) {
            $size /= 1024;
            $index++;
        }

        return round($size, 2) . ' ' . $units[$index];
    }

    public static function ago(int $timestamp): string
    {
        $diff = time() - $timestamp;

        if ($diff < 60) {
            return $diff . 's';
        }

        if ($diff < 3600) {
            return intdiv($diff, 60) . 'm';
        }

        if ($diff < 86400) {
            return intdiv($diff, 3600) . 'h';
        }

        return intdiv($diff, 86400) . 'd';
    }

    /**
     * Flatten a normalized DTO into [label, value] rows for a key/value table.
     *
     * @param array<array-key, mixed> $data
     * @return array<int, array{0: string, 1: string}>
     */
    public static function keyValueRows(array $data): array
    {
        $rows = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_SLASHES);
            }

            $rows[] = [$key, self::value($value)];
        }

        return $rows;
    }
}
