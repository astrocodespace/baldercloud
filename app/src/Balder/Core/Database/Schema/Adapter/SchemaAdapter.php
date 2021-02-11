<?php

namespace Astrocode\Balder\Core\Database\Schema\Adapter;

use Laminas\Db\Adapter\Adapter;

interface SchemaAdapter
{
    public function getSchemaName(): string;

    public function getCollections(array $params = []): iterable;

    public function getConnection(): Adapter;
}
