<?php

declare(strict_types=1);

use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Dto\Container\CreateContainer;
use Misaf\DockerEngine\Dto\Container\LogsOptions;
use Misaf\DockerEngine\Exec\ExecRunOptions;

it('covers critical stable API behavior against a real compatible daemon', function (): void {
    if ('1' !== getenv('DOCKER_SDK_INTEGRATION')) {
        test()->markTestSkipped('Set DOCKER_SDK_INTEGRATION=1 to run Docker daemon integration tests.');
    }

    $client = DockerClient::create(getenv('DOCKER_HOST') ?: 'unix:///var/run/docker.sock');

    $image = 'docker.io/library/alpine:3.20';
    $container = 'docker-sdk-integration-' . bin2hex(random_bytes(4));
    $network = $container . '-network';
    $volume = $container . '-volume';

    foreach ($client->images()->pull($image) as $event) {
        expect($event->error)->toBeNull();
    }

    try {
        expect($client->system()->ping())->toBe('OK')
            ->and($client->system()->info()->operatingSystem)->not->toBe('')
            ->and($client->containers()->list())->toBeArray()
            ->and($client->images()->list())->not->toBeEmpty();

        $created = $client->containers()->create(new CreateContainer(
            image: $image,
            name: $container,
            command: ['sh', '-c', 'echo stdout; echo stderr >&2'],
        ));
        $client->containers()->start($created->id);
        $client->raw()->request('POST', '/containers/' . rawurlencode($created->id->value) . '/wait');

        $stdout = '';
        $stderr = '';
        $client->containers()->logs($created->id, new LogsOptions())->consume(
            static function (string $chunk) use (&$stdout): void {
                $stdout .= $chunk;
            },
            static function (string $chunk) use (&$stderr): void {
                $stderr .= $chunk;
            },
        );

        expect($stdout)->toContain('stdout')
            ->and($stderr)->toContain('stderr');

        $client->containers()->remove($created->id);
        $created = $client->containers()->create(new CreateContainer(
            image: $image,
            name: $container,
            command: ['sleep', '30'],
        ));
        $client->containers()->start($created->id);
        $exec = $client->exec()->run($created->id, ['sh', '-c', 'echo exec-out; echo exec-err >&2'], new ExecRunOptions());

        expect($exec->exitCode)->toBe(0)
            ->and($exec->stdout)->toContain('exec-out')
            ->and($exec->stderr)->toContain('exec-err');

        $client->raw()->request('POST', '/networks/create', body: ['Name' => $network]);
        $client->raw()->request('POST', '/volumes/create', body: ['Name' => $volume]);

        expect(array_column($client->networks()->list(), 'name'))->toContain($network)
            ->and(array_map(static fn($item): string => $item->name->value, $client->volumes()->list()))->toContain($volume);
    } finally {
        try {
            $client->containers()->remove($container, force: true, removeVolumes: true);
        } catch (Throwable) {
        }

        try {
            $client->raw()->request('DELETE', '/networks/' . rawurlencode($network));
        } catch (Throwable) {
        }

        try {
            $client->raw()->request('DELETE', '/volumes/' . rawurlencode($volume), ['force' => true]);
        } catch (Throwable) {
        }
    }
})->group('docker-integration');
