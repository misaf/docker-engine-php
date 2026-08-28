<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Console;

use Misaf\DockerEngine\Tools\OpenApi\ApiCoverageValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'docker-api:coverage', description: 'Validate generated endpoint, tag, and schema coverage against every Docker spec.')]
final class CoverageCommand extends Command
{
    public function __construct(private readonly ApiCoverageValidator $validator)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $result = $this->validator->validate();
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        (new Table($output))
            ->setHeaders(['Version', 'Operations', 'Implemented', 'Coverage', 'Schemas', 'Generated'])
            ->setRows($result['rows'])
            ->render();

        foreach ($result['errors'] as $error) {
            $io->error($error);
        }

        return [] === $result['errors'] ? Command::SUCCESS : Command::FAILURE;
    }
}
