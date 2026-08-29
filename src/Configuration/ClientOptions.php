<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Configuration;

use InvalidArgumentException;
use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Transport\TlsOptions;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class ClientOptions
{
    /** @param array<string, string> $headers */
    public function __construct(
        public string $host = 'unix:///var/run/docker.sock',
        public ?ApiVersion $apiVersion = null,
        public TimeoutOptions $timeouts = new TimeoutOptions(),
        public ?TlsOptions $tls = null,
        public array $headers = [],
    ) {
        self::validateHost($this->host);

        if (null !== $this->tls && ! str_starts_with($this->host, 'https://')) {
            throw new InvalidArgumentException('TLS options require an https:// engine host.');
        }
    }

    /**
     * Validate an array-shaped boundary once, then expose only typed options.
     *
     * @param array<array-key, mixed> $options
     */
    public static function resolve(array $options = []): self
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'host'        => 'unix:///var/run/docker.sock',
            'api_version' => null,
            'timeouts'    => new TimeoutOptions(),
            'tls'         => null,
            'headers'     => [],
        ]);
        $resolver->setAllowedTypes('host', 'string');
        $resolver->setAllowedTypes('api_version', ['null', 'string', ApiVersion::class]);
        $resolver->setAllowedTypes('timeouts', [TimeoutOptions::class, 'array']);
        $resolver->setAllowedTypes('tls', [TlsOptions::class, 'array', 'null']);
        $resolver->setAllowedTypes('headers', 'array');
        $resolver->setNormalizer('host', static function (Options $options, string $host): string {
            $host = mb_rtrim(mb_trim($host), '/');

            if (str_starts_with($host, 'tcp://')) {
                $host = 'http://' . mb_substr($host, 6);
            }

            self::validateHost($host);

            return $host;
        });
        $resolver->setNormalizer('api_version', static fn(Options $options, ApiVersion|string|null $version): ?ApiVersion => is_string($version) ? ApiVersion::parse($version) : $version);
        $resolver->setNormalizer('timeouts', static function (Options $options, TimeoutOptions|array $timeouts): TimeoutOptions {
            if ($timeouts instanceof TimeoutOptions) {
                return $timeouts;
            }

            $timeoutResolver = new OptionsResolver();
            $timeoutResolver->setDefaults(['connect' => 5.0, 'request' => 60.0, 'stream_idle' => null]);
            $timeoutResolver->setAllowedTypes('connect', ['int', 'float']);
            $timeoutResolver->setAllowedTypes('request', ['int', 'float']);
            $timeoutResolver->setAllowedTypes('stream_idle', ['null', 'int', 'float']);
            $resolved = $timeoutResolver->resolve($timeouts);
            $connect = $resolved['connect'];
            $request = $resolved['request'];
            $streamIdle = $resolved['stream_idle'];

            if (( ! is_int($connect) && ! is_float($connect))
                || ( ! is_int($request) && ! is_float($request))
                || (null !== $streamIdle && ! is_int($streamIdle) && ! is_float($streamIdle))) {
                throw new InvalidArgumentException('Timeout values must be numeric.');
            }

            return new TimeoutOptions((float) $connect, (float) $request, null === $streamIdle ? null : (float) $streamIdle);
        });
        $resolver->setNormalizer('tls', static function (Options $options, TlsOptions|array|null $tls): ?TlsOptions {
            if (null === $tls || $tls instanceof TlsOptions) {
                return $tls;
            }

            $tlsResolver = new OptionsResolver();
            $tlsResolver->setDefaults([
                'ca'                   => null,
                'certificate'          => null,
                'private_key'          => null,
                'private_key_password' => null,
                'verify_peer'          => true,
                'verify_host'          => true,
            ]);
            $tlsResolver->setAllowedTypes('ca', ['null', 'string']);
            $tlsResolver->setAllowedTypes('certificate', ['null', 'string']);
            $tlsResolver->setAllowedTypes('private_key', ['null', 'string']);
            $tlsResolver->setAllowedTypes('private_key_password', ['null', 'string']);
            $tlsResolver->setAllowedTypes('verify_peer', 'bool');
            $tlsResolver->setAllowedTypes('verify_host', 'bool');
            $resolved = $tlsResolver->resolve($tls);
            $ca = $resolved['ca'];
            $certificate = $resolved['certificate'];
            $privateKey = $resolved['private_key'];
            $privateKeyPassword = $resolved['private_key_password'];
            $verifyPeer = $resolved['verify_peer'];
            $verifyHost = $resolved['verify_host'];

            if ((null !== $ca && ! is_string($ca))
                || (null !== $certificate && ! is_string($certificate))
                || (null !== $privateKey && ! is_string($privateKey))
                || (null !== $privateKeyPassword && ! is_string($privateKeyPassword))
                || ! is_bool($verifyPeer)
                || ! is_bool($verifyHost)) {
                throw new InvalidArgumentException('TLS options contain invalid values.');
            }

            return new TlsOptions(
                $ca,
                $certificate,
                $privateKey,
                $privateKeyPassword,
                $verifyPeer,
                $verifyHost,
            );
        });
        $resolver->setNormalizer('headers', static function (Options $options, array $headers): array {
            foreach ($headers as $name => $value) {
                if ( ! is_string($name) || ! is_string($value)) {
                    throw new InvalidArgumentException('Client headers must be a string-to-string map.');
                }
            }

            return $headers;
        });
        $resolved = $resolver->resolve($options);
        $host = $resolved['host'];
        $apiVersion = $resolved['api_version'];
        $timeouts = $resolved['timeouts'];
        $tls = $resolved['tls'];
        $headers = $resolved['headers'];

        if ( ! is_string($host)
            || (null !== $apiVersion && ! $apiVersion instanceof ApiVersion)
            || ! $timeouts instanceof TimeoutOptions
            || (null !== $tls && ! $tls instanceof TlsOptions)
            || ! is_array($headers)) {
            throw new InvalidArgumentException('Client options could not be normalized.');
        }

        foreach ($headers as $name => $value) {
            if ( ! is_string($name) || ! is_string($value)) {
                throw new InvalidArgumentException('Client headers must be a string-to-string map.');
            }
        }

        return new self(
            $host,
            $apiVersion,
            $timeouts,
            $tls,
            $headers,
        );
    }

    private static function validateHost(string $host): void
    {
        if (str_starts_with($host, 'unix://')) {
            if ('' === mb_substr($host, 7)) {
                throw new InvalidArgumentException('Unix engine socket path cannot be empty.');
            }

            return;
        }

        $parts = parse_url($host);

        if ( ! is_array($parts) || ! in_array($parts['scheme'] ?? null, ['http', 'https'], true) || ! is_string($parts['host'] ?? null)) {
            throw new InvalidArgumentException('Engine host must use unix://, tcp://, http://, or https://.');
        }
    }
}
