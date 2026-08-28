<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Console;

use Misaf\DockerEngine\Tools\Generator\GeneratorDeterminismChecker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'docker-api:determinism', description: 'Verify two generations from identical Docker specs produce identical output.')]
final class DeterminismCommand extends Command
{
    public function __construct(private readonly GeneratorDeterminismChecker $checker)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->checker->check();
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->success('Docker API generation is deterministic for the committed specs.');

        return Command::SUCCESS;
    }
}
