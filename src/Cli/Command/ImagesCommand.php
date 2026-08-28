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

#[AsCommand(name: 'images', description: 'List images.')]
final class ImagesCommand extends AbstractCommand
{
    protected function configure(): void
    {
        parent::configure();
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'Show all images (default hides intermediate images).');
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

            $response = $this->client($input)->raw()->request('GET', '/images/json', $query);
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
            /** @var array<int, string> $tags */
            $tags = $item['RepoTags'] ?? [];
            $tag = [] !== $tags ? Render::value($tags[0]) : '<none>';

            $created = $item['Created'] ?? null;
            $created = is_int($created) ? Render::ago($created) : '';

            $size = $item['Size'] ?? null;
            $size = is_int($size) ? Render::bytes($size) : '';

            $rows[] = [
                Render::value($item['Id'] ?? null),
                $tag,
                $created,
                $size,
            ];
        }

        $io->table(['IMAGE ID', 'REPOSITORY/TAG', 'CREATED', 'SIZE'], $rows);

        return Command::SUCCESS;
    }
}
