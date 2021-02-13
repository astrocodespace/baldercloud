<?php

namespace Astrocode\Balder\Core\Database\Schema\Factory;

interface ColumnFactoryInterface
{
    public static function create($name, $type): mixed;
}
