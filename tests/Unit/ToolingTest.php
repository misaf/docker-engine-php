<?php

declare(strict_types=1);

use Misaf\DockerEngine\Generated\ConnectionUpgrade;
use Misaf\DockerEngine\Generated\Endpoint;
use Misaf\DockerEngine\Generated\ResponseKind;
use Misaf\DockerEngine\Tools\Console\ValidateCommand;
use Misaf\DockerEngine\Tools\OpenApi\OpenApiSpecRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

it('represents generated endpoint behavior with closed enum types', function (): void {
    $endpoint = new Endpoint(
        operationId: 'ContainerAttachWebsocket',
        method: 'GET',
        path: '/containers/{id}/attach/ws',
        responseClass: null,
        responseKind: ResponseKind::Stream,
        upgrade: ConnectionUpgrade::WebSocket,
    );

    expect($endpoint->responseKind)->toBe(ResponseKind::Stream)
        ->and($endpoint->upgrade)->toBe(ConnectionUpgrade::WebSocket)
        ->and((new Endpoint('SystemPing', 'GET', '/_ping', null))->responseKind)->toBe(ResponseKind::Json);
});

it('discovers all Docker specs in deterministic version order with Finder', function (): void {
    $repository = new OpenApiSpecRepository(dirname(__DIR__, 2) . '/tools/specs');

    expect($repository->versions())
        ->toHaveCount(16)
        ->sequence('1.40', '1.41', '1.42', '1.43', '1.44', '1.45', '1.46', '1.47', '1.48', '1.49', '1.50', '1.51', '1.52', '1.53', '1.54', '1.55');
});

it('runs spec validation through a testable Symfony Console command', function (): void {
    $command = new CommandTester(new ValidateCommand(new OpenApiSpecRepository(dirname(__DIR__, 2) . '/tools/specs')));

    expect($command->execute(['--api-version' => '1.55']))->toBe(Command::SUCCESS)
        ->and($command->getDisplay())->toContain('Validated Docker OpenAPI v1.55');
});

it('returns a failing Console exit code for an invalid API version', function (): void {
    $command = new CommandTester(new ValidateCommand(new OpenApiSpecRepository(dirname(__DIR__, 2) . '/tools/specs')));

    expect($command->execute(['--api-version' => '1.56']))->toBe(Command::FAILURE)
        ->and($command->getDisplay())->toContain('unsupported');
});
