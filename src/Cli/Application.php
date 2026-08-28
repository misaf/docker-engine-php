<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Cli;

use Misaf\DockerEngine\Cli\Command\ImagesCommand;
use Misaf\DockerEngine\Cli\Command\InfoCommand;
use Misaf\DockerEngine\Cli\Command\PingCommand;
use Misaf\DockerEngine\Cli\Command\PsCommand;
use Misaf\DockerEngine\Cli\Command\VersionCommand;
use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('docker-engine-php', '1.0.0');

        $this->addCommands([
            new PingCommand(),
            new PsCommand(),
            new ImagesCommand(),
            new VersionCommand(),
            new InfoCommand(),
        ]);
    }
}
