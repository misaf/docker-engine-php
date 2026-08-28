<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Generated;

enum ConnectionUpgrade: string
{
    case Tcp = 'tcp';
    case WebSocket = 'websocket';
}
