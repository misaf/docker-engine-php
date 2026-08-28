<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Console;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Tools\Generator\DockerApiGenerator;
use Misaf\DockerEngine\Tools\OpenApi\OpenApiSpecRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'docker-api:generate', description: 'Generate versioned Docker Engine API classes from the committed OpenAPI specs.')]
final class GenerateCommand extends Command
{
    public function __construct(
        private readonly OpenApiSpecRepository $specs,
        private readonly DockerApiGenerator $generator,
        private readonly string $apiDirectory,
        private readonly string $clientFile,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('api-version', null, InputOption::VALUE_REQUIRED, 'Generate one supported API version, e.g. 1.55.');
        $this->addOption('all', null, InputOption::VALUE_NONE, 'Generate all committed API versions and DockerClient wiring.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $selected = $input->getOption('api-version');

        if ($input->getOption('all') && is_string($selected)) {
            $io->error('Use either --all or --api-version, not both.');

            return Command::INVALID;
        }

        try {
            $versions = is_string($selected) ? [ApiVersion::parse($selected)->value] : $this->specs->versions();

            foreach ($versions as $version) {
                $this->generator->generate($version, $this->specs->file($version), $this->apiDirectory);
                $io->writeln('Generated Docker Engine API v' . $version);
            }

            if (count($versions) === count($this->specs->versions())) {
                $this->generator->generateClient($versions, $this->clientFile);
                $io->writeln('Generated public DockerClient version wiring');
            }
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
