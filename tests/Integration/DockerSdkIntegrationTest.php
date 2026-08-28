<?php

declare(strict_types=1);

use Misaf\DockerEngine\DockerClient;

it('can negotiate and ping a real Docker daemon', function (): void {
    if ('1' !== getenv('DOCKER_SDK_INTEGRATION')) {
        test()->markTestSkipped('Set DOCKER_SDK_INTEGRATION=1 to run Docker daemon integration tests.');
    }

    $client = DockerClient::create(getenv('DOCKER_HOST') ?: 'unix:///var/run/docker.sock');

    expect($client->system()->ping())->toBe('OK');
})->group('docker-integration');
