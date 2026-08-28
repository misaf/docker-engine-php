<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Resources;

use Misaf\DockerEngine\Contracts\Api\ExecApi;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Exec\ExecResult;
use Misaf\DockerEngine\Exec\ExecRunOptions;
use Misaf\DockerEngine\Exec\ExecSession;
use Misaf\DockerEngine\Raw\RawApi;
use Misaf\DockerEngine\ValueObjects\ContainerId;
use Misaf\DockerEngine\ValueObjects\ExecId;

final readonly class Exec implements ExecApi
{
    public function __construct(private RawApi $raw) {}

    /** @param list<string> $command */
    public function run(ContainerId|string $container, array $command, ?ExecRunOptions $options = null): ExecResult
    {
        if ([] === $command) {
            throw new InvalidResponseException('An exec command is required.');
        }

        $options ??= new ExecRunOptions();
        $exec = $this->create($container, $command, $options);
        $session = $this->stream($exec, $options->tty);
        $stdout = '';
        $stderr = $options->tty ? null : '';

        try {
            $session->consume(
                static function (string $chunk) use (&$stdout): void {
                    $stdout .= $chunk;
                },
                static function (string $chunk) use (&$stderr): void {
                    if (null !== $stderr) {
                        $stderr .= $chunk;
                    }
                },
            );
        } finally {
            $session->close();
        }

        return new ExecResult($exec, $this->exitCode($exec), $stdout, $stderr, $options->tty);
    }

    public function stream(ExecId|string $exec, bool $tty = false): ExecSession
    {
        $exec = $exec instanceof ExecId ? $exec : new ExecId($exec);
        $response = $this->raw->stream(
            'POST',
            '/exec/' . rawurlencode($exec->value) . '/start',
            headers: ['Connection' => 'Upgrade', 'Upgrade' => 'tcp'],
            body: ['Detach' => false, 'Tty' => $tty],
        );

        return new ExecSession($exec, $response->stream, $tty);
    }

    /** @param list<string> $command */
    private function create(ContainerId|string $container, array $command, ExecRunOptions $options): ExecId
    {
        $response = $this->raw->request(
            'POST',
            '/containers/' . rawurlencode((string) $container) . '/exec',
            body: [
                'AttachStdin'  => $options->attachStdin,
                'AttachStdout' => true,
                'AttachStderr' => true,
                'Tty'          => $options->tty,
                'Cmd'          => $command,
                'Env'          => $options->environmentList(),
                'User'         => $options->user ?? '',
                'WorkingDir'   => $options->workingDirectory ?? '',
                'Privileged'   => $options->privileged,
            ],
        );
        $id = $response->json()['Id'] ?? null;

        if ( ! is_string($id) || '' === $id) {
            throw new InvalidResponseException('Docker did not return an exec ID.');
        }

        return new ExecId($id);
    }

    private function exitCode(ExecId $exec): int
    {
        $exitCode = $this->raw->request('GET', '/exec/' . rawurlencode($exec->value) . '/json')->json()['ExitCode'] ?? null;

        if ( ! is_int($exitCode)) {
            throw new InvalidResponseException('Docker exec inspection did not contain an integer ExitCode.');
        }

        return $exitCode;
    }
}
