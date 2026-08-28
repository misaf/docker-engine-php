<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Console;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Tools\OpenApi\OpenApiSpecRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'docker-api:validate', description: 'Parse Docker OpenAPI YAML and validate all local references.')]
final class ValidateCommand extends Command
{
    public function __construct(private readonly OpenApiSpecRepository $specs)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('api-version', null, InputOption::VALUE_REQUIRED, 'Validate one supported API version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $selected = $input->getOption('api-version');

        try {
            $versions = is_string($selected) ? [ApiVersion::parse($selected)->value] : $this->specs->versions();

            foreach ($versions as $version) {
                $unresolved = $this->specs->unresolvedReferences($this->specs->parse($version));

                if ([] !== $unresolved) {
                    $io->error(sprintf('v%s has unresolved references: %s', $version, implode(', ', $unresolved)));

                    return Command::FAILURE;
                }

                $io->writeln('Validated Docker OpenAPI v' . $version);
            }
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
