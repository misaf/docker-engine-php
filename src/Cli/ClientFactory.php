<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Cli;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Configuration\ClientOptions;
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Transport\TlsOptions;
use Symfony\Component\Console\Input\InputInterface;

final class ClientFactory
{
    public static function fromInput(InputInterface $input): DockerClient
    {
        $ca = $input->getOption('tls-ca');
        $cert = $input->getOption('tls-cert');
        $key = $input->getOption('tls-key');

        $tls = (is_string($ca) || is_string($cert) || is_string($key))
            ? new TlsOptions(
                is_string($ca) ? $ca : null,
                is_string($cert) ? $cert : null,
                is_string($key) ? $key : null,
                null,
                (bool) $input->getOption('tls-verify-peer'),
                (bool) $input->getOption('tls-verify-host'),
            )
            : null;

        $version = $input->getOption('api-version');
        $host = $input->getOption('host');
        $host = is_string($host) ? $host : 'unix:///var/run/docker.sock';

        $options = ClientOptions::resolve([
            'host' => $host,
            'api_version' => is_string($version) ? ApiVersion::parse($version) : null,
            'tls' => $tls,
        ]);

        return DockerClient::fromOptions($options);
    }
}
