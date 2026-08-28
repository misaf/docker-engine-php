<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tests\Support;

use LogicException;
use Misaf\DockerEngine\Contracts\Transport;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;

final class FakeDockerTransport implements Transport
{
    /** @var list<Request> */
    public array $requests = [];

    /** @var list<Response|StreamResponse> */
    private array $responses = [];

    public function queue(Response|StreamResponse ...$responses): self
    {
        array_push($this->responses, ...$responses);

        return $this;
    }

    public function request(Request $request): Response
    {
        $this->requests[] = $request;
        $response = array_shift($this->responses);

        if (! $response instanceof Response) {
            throw new LogicException('No buffered Docker response was queued.');
        }

        return $response;
    }

    public function stream(Request $request): StreamResponse
    {
        $this->requests[] = $request;
        $response = array_shift($this->responses);

        if (! $response instanceof StreamResponse) {
            throw new LogicException('No streaming Docker response was queued.');
        }

        return $response;
    }
}
