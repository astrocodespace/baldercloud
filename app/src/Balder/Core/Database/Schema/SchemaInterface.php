<?php


namespace Astrocode\Balder\Core\Database\Schema;


interface SchemaInterface
{
    public function getSchemaName(): string;

    public function getCollections(array $params = []): iterable;
}
