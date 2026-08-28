<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Generator;

use Misaf\DockerEngine\Tools\OpenApi\OpenApiSpecRepository;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final readonly class GeneratorDeterminismChecker
{
    public function __construct(
        private OpenApiSpecRepository $specs,
        private DockerApiGenerator $generator,
        private Filesystem $filesystem,
    ) {}

    public function check(): void
    {
        $temporary = sys_get_temp_dir() . '/docker-engine-php-generator-' . bin2hex(random_bytes(8));
        $versions = $this->specs->versions();

        try {
            foreach (['first', 'second'] as $run) {
                $this->generator->generateSupport($temporary . '/' . $run . '/Generated');

                foreach ($versions as $version) {
                    $this->generator->generate($version, $this->specs->file($version), $temporary . '/' . $run . '/Api');
                }

                $this->generator->generateClient($versions, $temporary . '/' . $run . '/DockerClient.php');
            }

            if ($this->checksums($temporary . '/first/Api') !== $this->checksums($temporary . '/second/Api')
                || $this->checksums($temporary . '/first/Generated') !== $this->checksums($temporary . '/second/Generated')
                || hash_file('sha256', $temporary . '/first/DockerClient.php') !== hash_file('sha256', $temporary . '/second/DockerClient.php')) {
                throw new RuntimeException('Two Docker API generations from identical specs produced different output.');
            }
        } finally {
            $this->filesystem->remove($temporary);
        }
    }

    /** @return array<string, string> */
    private function checksums(string $directory): array
    {
        $result = [];
        $finder = Finder::create()->files()->in($directory)->sortByName();

        foreach ($finder as $file) {
            $hash = hash_file('sha256', $file->getPathname());

            if (false !== $hash) {
                $result[$file->getRelativePathname()] = $hash;
            }
        }

        ksort($result);

        return $result;
    }
}
