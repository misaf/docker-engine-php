<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\Configuration\TimeoutOptions;
use Misaf\DockerEngine\Transport\TlsOptions;

it('validates and normalizes client options into typed configuration', function (): void {
    $options = ClientOptions::resolve([
        'host'        => 'tcp://docker.test:2375/',
        'api_version' => 'v1.55',
        'timeouts'    => ['connect' => 2, 'request' => 30, 'stream_idle' => 120],
        'headers'     => ['X-Registry-Auth' => 'token'],
    ]);

    expect($options->host)->toBe('http://docker.test:2375')
        ->and($options->apiVersion)->toBe(ApiVersion::V1_55)
        ->and($options->timeouts)->toEqual(new TimeoutOptions(2, 30, 120))
        ->and($options->headers)->toBe(['X-Registry-Auth' => 'token']);
});

it('keeps TLS typed and rejects invalid host and timeout combinations', function (): void {
    $options = ClientOptions::resolve([
        'host' => 'https://docker.test:2376',
        'tls'  => ['ca' => '/certs/ca.pem', 'certificate' => '/certs/cert.pem', 'private_key' => '/certs/key.pem'],
    ]);

    expect($options->tls)->toEqual(new TlsOptions('/certs/ca.pem', '/certs/cert.pem', '/certs/key.pem'));

    ClientOptions::resolve(['host' => 'ftp://docker.test']);
})->throws(InvalidArgumentException::class);

it('rejects unsupported explicit API versions', function (): void {
    ClientOptions::resolve(['api_version' => '1.56']);
})->throws(Misaf\DockerEngine\Exceptions\UnsupportedApiVersionException::class);

it('rejects TLS options for a non HTTPS host', function (): void {
    ClientOptions::resolve(['host' => 'http://docker.test:2375', 'tls' => new TlsOptions()]);
})->throws(InvalidArgumentException::class);
