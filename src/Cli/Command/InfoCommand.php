<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Cli\Command;

use Misaf\DockerEngine\Cli\Helper\Render;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'info', description: 'Display system-wide information.')]
final class InfoCommand extends AbstractCommand
{
    protected function configure(): void
    {
        parent::configure();
        $this->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format: table or json.', 'table');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $response = $this->client($input)->raw()->request('GET', '/info');
            /** @var array<string, mixed> $data */
            $data = $response->json();
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        if ('json' === $input->getOption('format')) {
            $io->writeln((string) json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return Command::SUCCESS;
        }

        $io->table(['FIELD', 'VALUE'], Render::keyValueRows($data));

        return Command::SUCCESS;
    }
}
