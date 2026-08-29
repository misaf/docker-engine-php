<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

enum ResponseKind: string
{
    case Json = 'json';
    case JsonArray = 'json-array';
    case Progress = 'progress';
    case Raw = 'raw';
    case Stream = 'stream';
    case Void = 'void';
}
