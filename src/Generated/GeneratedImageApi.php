<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\ValueObjects\ImageReference;

abstract class GeneratedImageApi extends GeneratedApi
{
    final public function pull(ImageReference|string $image, ?string $registryAuth = null): ProgressStream
    {
        $image = $image instanceof ImageReference ? $image : new ImageReference($image);
        $headers = null === $registryAuth ? [] : ['X-Registry-Auth' => $registryAuth];
        $response = $this->transport->stream(new Request(
            'POST',
            '/images/create',
            $this->version,
            ['fromImage' => $image->repository, 'tag' => $image->isPinned() ? null : $image->tag],
            $headers,
        ));

        if ($response->statusCode < 200 || $response->statusCode >= 300) {
            $body = '';

            while (! $response->stream->eof()) {
                $body .= $response->stream->read();
            }

            throw $this->errors->exception(new Response($response->statusCode, $response->headers, $body));
        }

        return new ProgressStream($response->stream);
    }
}
