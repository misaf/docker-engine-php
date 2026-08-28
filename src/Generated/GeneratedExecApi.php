<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Exec\ExecResult;
use Misaf\DockerEngine\Exec\ExecRunOptions;
use Misaf\DockerEngine\Exec\ExecSession;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Response;
use Misaf\DockerEngine\Transport\StreamResponse;
use Misaf\DockerEngine\ValueObjects\ContainerId;
use Misaf\DockerEngine\ValueObjects\ExecId;

abstract class GeneratedExecApi extends GeneratedApi
{
    /** @param list<string> $command */
    final public function run(
        ContainerId|string $container,
        array $command,
        ?ExecRunOptions $options = null,
    ): ExecResult {
        if ([] === $command) {
            throw new InvalidResponseException('An exec command is required.');
        }

        $options ??= new ExecRunOptions();
        $execId = $this->createExec($container, $command, $options);
        $session = $this->openSession($execId, $options->tty);
        $stdout = '';
        $stderr = $options->tty ? null : '';

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
        $session->close();

        return new ExecResult(
            $execId,
            $this->inspectExitCode($execId),
            $stdout,
            $stderr,
            $options->tty,
        );
    }

    final public function stream(ExecId|string $exec, bool $tty = false): ExecSession
    {
        return $this->openSession($exec instanceof ExecId ? $exec : new ExecId($exec), $tty);
    }

    /** @param list<string> $command */
    private function createExec(ContainerId|string $container, array $command, ExecRunOptions $options): ExecId
    {
        $response = $this->transport->request(new Request(
            'POST',
            '/containers/' . rawurlencode((string) $container) . '/exec',
            $this->version,
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
        ));
        $this->assertSuccess($response);
        $id = $response->json()['Id'] ?? null;

        if (! is_string($id) || '' === $id) {
            throw new InvalidResponseException('Docker did not return an exec ID.');
        }

        return new ExecId($id);
    }

    private function openSession(ExecId $exec, bool $tty): ExecSession
    {
        $response = $this->transport->stream(new Request(
            'POST',
            '/exec/' . rawurlencode($exec->value) . '/start',
            $this->version,
            headers: ['Connection' => 'Upgrade', 'Upgrade' => 'tcp'],
            body: ['Detach' => false, 'Tty' => $tty],
        ));
        $this->assertStreamSuccess($response);

        return new ExecSession($exec, $response->stream, $tty);
    }

    private function inspectExitCode(ExecId $exec): int
    {
        $response = $this->transport->request(new Request(
            'GET',
            '/exec/' . rawurlencode($exec->value) . '/json',
            $this->version,
        ));
        $this->assertSuccess($response);
        $exitCode = $response->json()['ExitCode'] ?? null;

        if (! is_int($exitCode)) {
            throw new InvalidResponseException('Docker exec inspection did not contain an integer ExitCode.');
        }

        return $exitCode;
    }

    private function assertSuccess(Response $response): void
    {
        if (! $response->successful()) {
            throw $this->errors->exception($response);
        }
    }

    private function assertStreamSuccess(StreamResponse $response): void
    {
        if (101 === $response->statusCode || ($response->statusCode >= 200 && $response->statusCode < 300)) {
            return;
        }

        $body = '';

        while (! $response->stream->eof()) {
            $body .= $response->stream->read();
        }

        throw $this->errors->exception(new Response($response->statusCode, $response->headers, $body));
    }
}
