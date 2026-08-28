<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Exec;

final readonly class ExecRunOptions
{
    /** @param array<string, string> $environment */
    public function __construct(
        public bool $tty = false,
        public bool $attachStdin = false,
        public ?string $user = null,
        public ?string $workingDirectory = null,
        public array $environment = [],
        public bool $privileged = false,
    ) {}

    /** @return list<string> */
    public function environmentList(): array
    {
        $result = [];

        foreach ($this->environment as $name => $value) {
            $result[] = $name . '=' . $value;
        }

        return $result;
    }
}
