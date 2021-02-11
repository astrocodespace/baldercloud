<?php

namespace Astrocode\Balder\Core\Services;

use Astrocode\Balder\Core\Database\Exception\CollectionAlreadyExistsException;
use Astrocode\Balder\Core\Database\Exception\CollectionNotFoundException;
use Astrocode\Balder\Core\Database\Exception\UnprocessableEntityException\UnprocessableEntityException;
use Astrocode\Balder\Core\Database\Schema\SchemaFactory;
use Astrocode\Balder\Core\Database\Schema\SchemaInterface;
use Astrocode\Balder\Core\Database\Schema\SchemaManager;
use Illuminate\Support\Collection;
use Laminas\Db\Sql\Ddl\CreateTable;

class TablesService
{
    /**
     * @var SchemaManager
     */
    private SchemaManager $schemaManager;

    /**
     * @var SchemaFactory
     */
    private SchemaFactory $schemaFactory;

    public function __construct(SchemaManager $schemaManager,
                                SchemaFactory $schemaFactory)
    {
        $this->schemaManager = $schemaManager;
        $this->schemaFactory = $schemaFactory;
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

        if (!$this->hasUniquePrimaryField($fields)) {
            throw new UnprocessableEntityException('Collection can only have one primary key field');
        }

        if (!$this->hasPrimaryField($fields)) {
            throw new UnprocessableEntityException('Collection does not have primary key field');
        }

        if (!$this->hasUniqueFields($fields)) {
            throw new UnprocessableEntityException('Collection fields must have unique names');
        }

        if (!$this->hasUniqueAutoIncrementFields($fields)) {
            throw new UnprocessableEntityException('Collection can not have more than one autoincrement field');
        }




        $table = $this->schemaFactory->createTable($tableName, ...$fields);
        try {
        $result = $this->schemaFactory->buildTable($table);
        } catch (\Throwable $exception) {
            dd($exception);
        }
        dd($result);
    }

    private function hasPrimaryField(Collection $fields)
    {
        $isPrimary = $fields->filter(function (Collection $field) {
            return $field->get('primary_key');
        });

        return count($isPrimary) > 0;
    }

    private function hasUniqueFields(Collection $fields)
    {
        return $fields->unique(function (Collection $field) {
            return $field->get('field');
        })->count() == $fields->count();
    }

    private function hasUniquePrimaryField(Collection $fields)
    {
        return $fields->filter(function (Collection $field) {
            return $field->get('primary_key');
        })->count() < 2;
    }

    private function hasUniqueAutoIncrementFields(Collection $fields)
    {
        return $fields->filter(function (Collection $field) {
            return $field->get('auto_increment');
        })->count() == 1;
    }
}
