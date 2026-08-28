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

#[AsCommand(name: 'ps', description: 'List containers.')]
final class PsCommand extends AbstractCommand
{
    protected function configure(): void
    {
        parent::configure();
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Show all containers (default shows just running).');
        $this->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format: table or json.', 'table');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $query = [];

            if ($input->getOption('all')) {
                $query['all'] = true;
            }

            $response = $this->client($input)->raw()->request('GET', '/containers/json', $query);
            /** @var array<int, array<string, mixed>> $items */
            $items = $response->json();
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        if ('json' === $input->getOption('format')) {
            $io->writeln((string) json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return Command::SUCCESS;
        }

        $rows = [];

        foreach ($items as $item) {
            /** @var array<int, array<string, mixed>> $ports */
            $ports = $item['Ports'] ?? [];
            $portStrings = array_map(
                static function (array $port): string {
                    $public = $port['PublicPort'] ?? null;
                    $private = $port['PrivatePort'] ?? null;
                    $type = $port['Type'] ?? null;

                    return Render::value($public) . ':' . Render::value($private) . '/' . Render::value($type);
                },
                $ports,
            );

            /** @var array<int, string> $names */
            $names = $item['Names'] ?? [];
            $name = [] !== $names ? ltrim(Render::value($names[0]), '/') : '';

            $created = $item['Created'] ?? null;
            $created = is_int($created) ? Render::ago($created) : '';

            $rows[] = [
                Render::value($item['Id'] ?? null),
                Render::value($item['Image'] ?? null),
                Render::value($item['Command'] ?? null),
                $created,
                Render::value($item['Status'] ?? null),
                implode(', ', $portStrings),
                $name,
            ];
        }

        $io->table(
            ['CONTAINER ID', 'IMAGE', 'COMMAND', 'CREATED', 'STATUS', 'PORTS', 'NAMES'],
            $rows,
        );

        return Command::SUCCESS;
    }
}
