<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Transport\ChunkedStream;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\ResourceStream;

it('constructs versioned targets and preserves repeated query parameters', function (): void {
    $request = new Request('GET', '/containers/json', ApiVersion::V1_55, [
        'all'     => true,
        'filters' => ['one', 'two'],
        'missing' => null,
    ]);

    expect($request->target())->toBe('/v1.55/containers/json?all=true&filters=one&filters=two');
});

it('decodes HTTP chunk framing without buffering the whole stream', function (): void {
    $stream = new ChunkedStream(ResourceStream::memory("4\r\nWiki\r\n5\r\npedia\r\n0\r\n\r\n"));
    $body = '';

    while (! $stream->eof()) {
        $body .= $stream->read(3);
    }

    expect($body)->toBe('Wikipedia');
});
