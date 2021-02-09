<?php

namespace Astrocode\Balder\Core\Database;


use Laminas\Db\Adapter\Platform;
use Laminas\Db\Adapter\Profiler;
use Laminas\Db\ResultSet;

class Adapter extends \Laminas\Db\Adapter\Adapter
{
    public function __construct(array $config,
                                Platform\PlatformInterface $platform = null,
                                ResultSet\ResultSetInterface $queryResultPrototype = null,
                                Profiler\ProfilerInterface $profiler = null
    )
    {
        parent::__construct(
            [
                'driver' => $config['driver'],
                'database' => $config['database'],
                'username' => $config['username'],
                'password' => $config['password'],
                'hostname' => $config['hostname'],
                'port' => $config['port']
            ],
            $platform,
            $queryResultPrototype,
            $profiler
        );
    }

}
