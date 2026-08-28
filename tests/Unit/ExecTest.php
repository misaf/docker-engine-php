<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Tests\Support\FakeDockerTransport;
use Misaf\DockerEngine\Transport\ResourceStream;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;
use Misaf\DockerEngine\ValueObjects\ContainerId;

it('runs exec over the Engine API and separates stdout from stderr', function (): void {
    $transport = new FakeDockerTransport()->queue(
        new Response(201, [], '{"Id":"exec-1"}'),
        new StreamResponse(101, ['Upgrade' => ['tcp']], ResourceStream::memory(
            dockerFrame(1, 'PHP 8.4') . dockerFrame(2, 'warning'),
        )),
        new Response(200, [], '{"ExitCode":0}'),
    );
    $result = (new DockerClient($transport, ApiVersion::V1_55))->exec()->run(
        new ContainerId('web'),
        ['php', '-v'],
    );

    expect($result->successful())->toBeTrue()
        ->and($result->stdout)->toBe('PHP 8.4')
        ->and($result->stderr)->toBe('warning')
        ->and($transport->requests)->toHaveCount(3)
        ->and($transport->requests[1]->headers)->toMatchArray(['Connection' => 'Upgrade', 'Upgrade' => 'tcp']);
});

it('does not claim stderr separation for a TTY exec', function (): void {
    $transport = new FakeDockerTransport()->queue(
        new Response(201, [], '{"Id":"exec-tty"}'),
        new StreamResponse(101, [], ResourceStream::memory("terminal\r\n")),
        new Response(200, [], '{"ExitCode":1}'),
    );
    $result = (new DockerClient($transport, ApiVersion::V1_55))->exec()->run(
        'web',
        ['false'],
        new Misaf\DockerEngine\Exec\ExecRunOptions(tty: true),
    );

    expect($result->tty)->toBeTrue()
        ->and($result->stdout)->toBe("terminal\r\n")
        ->and($result->stderr)->toBeNull()
        ->and($result->successful())->toBeFalse();
});
