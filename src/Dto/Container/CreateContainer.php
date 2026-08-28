<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Dto\Container;

final readonly class CreateContainer
{
    /**
     * @param list<string> $command
     * @param array<string, string> $environment
     * @param array<string, string> $labels
     */
    public function __construct(
        public string $image,
        public ?string $name = null,
        public array $command = [],
        public array $environment = [],
        public array $labels = [],
        public bool $tty = false,
        public bool $openStdin = false,
        public ?string $platform = null,
    ) {}

    /** @return array<string, mixed> */
    public function body(): array
    {
        $body = [
            'Image'     => $this->image,
            'Tty'       => $this->tty,
            'OpenStdin' => $this->openStdin,
        ];

        if ([] !== $this->command) {
            $body['Cmd'] = $this->command;
        }

        if ([] !== $this->environment) {
            $body['Env'] = array_map(
                static fn(string $name, string $value): string => $name . '=' . $value,
                array_keys($this->environment),
                array_values($this->environment),
            );
        }

        if ([] !== $this->labels) {
            $body['Labels'] = $this->labels;
        }

        return $body;
    }
}
