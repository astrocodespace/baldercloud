<?php

namespace Astrocode\Balder\Core\Database\Schema;

use Astrocode\Balder\Core\Database\Adapter;
use Astrocode\Balder\Core\Database\Exception\CollectionNotFoundException;
use Astrocode\Balder\Core\Database\Schema\Adapter\SchemaAdapter;
use Illuminate\Support\Collection;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;

interface SchemaManagerInterface
{
    public function getCollection($name): Collection;

    public function getCollections($params = []): Collection;

    public function getSchema();

    public function getConnection();
}
