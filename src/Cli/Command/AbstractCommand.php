<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Cli\Command;

use Misaf\DockerEngine\Cli\ClientFactory;
use Misaf\DockerEngine\DockerClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractCommand extends Command
{
    protected function configure(): void
    {
        $this->addOption('host', null, InputOption::VALUE_REQUIRED, 'Docker engine host.', 'unix:///var/run/docker.sock');
        $this->addOption('api-version', null, InputOption::VALUE_REQUIRED, 'Pin the Engine API version, e.g. 1.55.');
        $this->addOption('tls-ca', null, InputOption::VALUE_REQUIRED, 'Path to the TLS CA certificate file.');
        $this->addOption('tls-cert', null, InputOption::VALUE_REQUIRED, 'Path to the TLS client certificate file.');
        $this->addOption('tls-key', null, InputOption::VALUE_REQUIRED, 'Path to the TLS client private key file.');
        $this->addOption('tls-verify-peer', null, InputOption::VALUE_NEGATABLE, 'Verify the peer certificate.', true);
        $this->addOption('tls-verify-host', null, InputOption::VALUE_NEGATABLE, 'Verify the peer host name.', true);
    }

    protected function client(InputInterface $input): DockerClient
    {
        return ClientFactory::fromInput($input);
    }
}
