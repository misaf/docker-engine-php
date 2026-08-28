<?php

declare(strict_types=1);

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\Configuration\TimeoutOptions;
use Misaf\DockerEngine\Exceptions\ConnectionException;
use Misaf\DockerEngine\Serialization\SymfonySerializer;
use Misaf\DockerEngine\Transport\Request;
use Misaf\DockerEngine\Transport\Symfony\SymfonyTransport;
use Misaf\DockerEngine\Transport\TlsOptions;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

it('maps Unix sockets, HTTP details, JSON, headers, query, and timeouts internally', function (): void {
    $client = new MockHttpClient(function (string $method, string $url, array $options): MockResponse {
        expect($method)->toBe('POST')
            ->and($url)->toBe('http://localhost/v1.55/containers/create?name=web')
            ->and($options['bindto'])->toBe('/var/run/docker.sock')
            ->and($options['max_connect_duration'])->toBe(3.0)
            ->and($options['max_duration'])->toBe(45.0)
            ->and(json_decode($options['body'], true))->toBe(['Image' => 'php:8.4'])
            ->and($options['normalized_headers']['x-test'][0])->toBe('X-Test: yes');

        return new MockResponse('{"Id":"abc"}', ['http_code' => 201, 'response_headers' => ['content-type: application/json']]);
    });
    $transport = new SymfonyTransport(
        new ClientOptions(timeouts: new TimeoutOptions(3, 45), headers: ['X-Test' => 'yes']),
        new SymfonySerializer(),
        $client,
    );
    $response = $transport->request(new Request('POST', '/containers/create', ApiVersion::V1_55, ['name' => 'web'], body: ['Image' => 'php:8.4']));

    expect($response->statusCode)->toBe(201)->and($response->json())->toBe(['Id' => 'abc']);
});

it('maps HTTPS client certificates without exposing Symfony option arrays', function (): void {
    $client = new MockHttpClient(function (string $method, string $url, array $options): MockResponse {
        expect($url)->toBe('https://docker.test:2376/_ping')
            ->and($options)->toMatchArray([
                'verify_peer' => false,
                'verify_host' => false,
                'cafile'      => '/tls/ca.pem',
                'local_cert'  => '/tls/cert.pem',
                'local_pk'    => '/tls/key.pem',
                'passphrase'  => 'secret',
            ]);

        return new MockResponse('OK');
    });
    $options = new ClientOptions(
        'https://docker.test:2376',
        tls: new TlsOptions('/tls/ca.pem', '/tls/cert.pem', '/tls/key.pem', 'secret', false, false),
    );

    expect((new SymfonyTransport($options, new SymfonySerializer(), $client))->request(new Request('GET', '/_ping'))->body)->toBe('OK');
});

it('streams ordinary responses without buffering the complete body', function (): void {
    $client = new MockHttpClient(function (string $method, string $url, array $options): MockResponse {
        expect($options['timeout'])->toBe(60.0)
            ->and($options['max_duration'])->toBe(0.0);

        return new MockResponse(['first', 'second'], ['http_code' => 200]);
    });
    $response = (new SymfonyTransport(new ClientOptions(), new SymfonySerializer(), $client))->stream(new Request('GET', '/events'));
    $body = '';

    while ( ! $response->stream->eof()) {
        $body .= $response->stream->read(3);
    }

    expect($body)->toBe('firstsecond');
});

it('translates Symfony connection failures into SDK exceptions', function (): void {
    $client = new MockHttpClient(new MockResponse('', ['error' => 'connection refused']));
    $transport = new SymfonyTransport(new ClientOptions(), new SymfonySerializer(), $client);

    $transport->request(new Request('GET', '/_ping'));
})->throws(ConnectionException::class, 'connection refused');
