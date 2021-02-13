<?php

namespace Astrocode\Balder\Core\Database\Schema;

use Illuminate\Support\Collection;

interface SchemaFactoryInterface
{
    public function createTable(string $name, iterable ...$columns);

    public function createColumns(array $data): array;

    public function createColumn(string $field, Collection $column): mixed;

    public function buildTable($table, $charset = '');
}
