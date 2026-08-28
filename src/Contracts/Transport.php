<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Contracts;

use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;

interface Transport
{
    public function request(Request $request): Response;

    public function stream(Request $request): StreamResponse;
}
