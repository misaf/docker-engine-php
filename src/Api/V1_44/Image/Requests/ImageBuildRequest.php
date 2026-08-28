<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Api\V1_44\Image\Requests;

use Misaf\DockerEngine\Generated\GeneratedRequest;
use Misaf\DockerEngine\Generated\RequestParameter;
use Misaf\DockerEngine\Serialization\Undefined;

final readonly class ImageBuildRequest extends GeneratedRequest
{
    /**
     * @param string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $inputStream
     */
    public function __construct(
        #[RequestParameter('inputStream', 'body', false)]
        public string|\Misaf\DockerEngine\Contracts\Stream\Stream|Undefined $inputStream = Undefined::Value,
        #[RequestParameter('dockerfile', 'query', false)]
        public string|Undefined $dockerfile = Undefined::Value,
        #[RequestParameter('t', 'query', false)]
        public string|Undefined $t = Undefined::Value,
        #[RequestParameter('extrahosts', 'query', false)]
        public string|Undefined $extrahosts = Undefined::Value,
        #[RequestParameter('remote', 'query', false)]
        public string|Undefined $remote = Undefined::Value,
        #[RequestParameter('q', 'query', false)]
        public bool|Undefined $q = Undefined::Value,
        #[RequestParameter('nocache', 'query', false)]
        public bool|Undefined $nocache = Undefined::Value,
        #[RequestParameter('cachefrom', 'query', false)]
        public string|Undefined $cachefrom = Undefined::Value,
        #[RequestParameter('pull', 'query', false)]
        public string|Undefined $pull = Undefined::Value,
        #[RequestParameter('rm', 'query', false)]
        public bool|Undefined $rm = Undefined::Value,
        #[RequestParameter('forcerm', 'query', false)]
        public bool|Undefined $forcerm = Undefined::Value,
        #[RequestParameter('memory', 'query', false)]
        public int|Undefined $memory = Undefined::Value,
        #[RequestParameter('memswap', 'query', false)]
        public int|Undefined $memswap = Undefined::Value,
        #[RequestParameter('cpushares', 'query', false)]
        public int|Undefined $cpushares = Undefined::Value,
        #[RequestParameter('cpusetcpus', 'query', false)]
        public string|Undefined $cpusetcpus = Undefined::Value,
        #[RequestParameter('cpuperiod', 'query', false)]
        public int|Undefined $cpuperiod = Undefined::Value,
        #[RequestParameter('cpuquota', 'query', false)]
        public int|Undefined $cpuquota = Undefined::Value,
        #[RequestParameter('buildargs', 'query', false)]
        public string|Undefined $buildargs = Undefined::Value,
        #[RequestParameter('shmsize', 'query', false)]
        public int|Undefined $shmsize = Undefined::Value,
        #[RequestParameter('squash', 'query', false)]
        public bool|Undefined $squash = Undefined::Value,
        #[RequestParameter('labels', 'query', false)]
        public string|Undefined $labels = Undefined::Value,
        #[RequestParameter('networkmode', 'query', false)]
        public string|Undefined $networkmode = Undefined::Value,
        #[RequestParameter('Content-type', 'header', false)]
        public string|Undefined $contentType = Undefined::Value,
        #[RequestParameter('X-Registry-Config', 'header', false)]
        public string|Undefined $xRegistryConfig = Undefined::Value,
        #[RequestParameter('platform', 'query', false)]
        public string|Undefined $platform = Undefined::Value,
        #[RequestParameter('target', 'query', false)]
        public string|Undefined $target = Undefined::Value,
        #[RequestParameter('outputs', 'query', false)]
        public string|Undefined $outputs = Undefined::Value,
        #[RequestParameter('version', 'query', false)]
        public string|Undefined $version = Undefined::Value,
    ) {}
}
