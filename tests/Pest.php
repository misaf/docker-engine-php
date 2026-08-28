<?php

declare(strict_types=1);

function dockerFrame(int $stream, string $payload): string
{
    return chr($stream) . "\0\0\0" . pack('N', mb_strlen($payload, '8bit')) . $payload;
}
