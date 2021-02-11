<?php

namespace Astrocode\Balder\Core\Services;

use Astrocode\Balder\Core\Database\Exception\CollectionAlreadyExistsException;
use Astrocode\Balder\Core\Database\Exception\CollectionNotFoundException;
use Astrocode\Balder\Core\Database\Exception\UnprocessableEntityException\UnprocessableEntityException;
use Astrocode\Balder\Core\Database\Schema\SchemaInterface;
use Astrocode\Balder\Core\Database\Schema\SchemaManager;
use Illuminate\Support\Collection;
use Laminas\Db\Sql\Ddl\CreateTable;

class TablesService
{
    /**
     * @var SchemaInterface
     */
    private SchemaManager $schemaManager;

    public function __construct(SchemaManager $schemaManager)
    {
        $this->schemaManager = $schemaManager;
    }

    public function createTable(string $projectId, string $name, Collection $fields)
    {
        // @TODO: CHECK IF TABLE EXISTS
        $tableName = str_pad($projectId, 6, '0', STR_PAD_LEFT) . '_' . $name;

        $collection = null;
        try {
            $collection = $this->schemaManager->getCollection($tableName);
        } catch (CollectionNotFoundException $exception) {
            //
        }

        if ($collection && $collection->get('is_managed')) {
            throw new CollectionAlreadyExistsException('Collection already exists');
        }

        if (!$this->hasPrimaryField($fields)) {
            throw new UnprocessableEntityException('Collection does not have primary key field');
        }

        if (!$this->hasUniqueFields($fields)) {
            throw new UnprocessableEntityException('Collection fields must have unique names');
        }

        $table = new CreateTable($tableName);

        dd($table);
    }

    private function hasPrimaryField(Collection $fields)
    {
        $isPrimary = $fields->filter(function ($field) {
            return $field['primary_key'];
        });

        return count($isPrimary) > 0;
    }

    private function hasUniqueFields(Collection $fields)
    {
        return $fields->unique(function ($field) {
            return $field['field'];
        })->count() == $fields->count();
    }
}
