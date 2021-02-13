<?php

namespace Astrocode\Balder\Core\Database\Schema\Adapter\LaminasDb;

use Illuminate\Support\Collection;
use Laminas\Db\Sql\AbstractSql;
use Laminas\Db\Sql\Ddl\Column\AbstractLengthColumn;
use Laminas\Db\Sql\Ddl\Column\AbstractPrecisionColumn;
use Laminas\Db\Sql\Ddl\Column\Column;
use Laminas\Db\Sql\Ddl\Column\Integer;
use Laminas\Db\Sql\Ddl\Constraint\PrimaryKey;
use Laminas\Db\Sql\Ddl\Constraint\UniqueKey;
use Laminas\Db\Sql\Ddl\CreateTable;
use Laminas\Db\Sql\Sql;

class SchemaFactory
{
    /**
     * @var SchemaManager
     */
    private SchemaManager $schemaManager;

    public function __construct(SchemaManager $schemaManager)
    {
        $this->schemaManager = $schemaManager;
    }

    /**
     * @param string $name
     * @param Collection ...$columns
     * @return CreateTable
     */
    public function createTable(string $name, Collection ...$columns)
    {
        $table = new CreateTable($name);
        $dbColumns = $this->createColumns($columns);

        foreach ($columns as $column) {
            $field = $column->get('field');
            if ($column->get('primary_key', false)) {
                $table->addConstraint(new PrimaryKey($field));
            } elseif ($column->get('unique')) {
                $table->addConstraint(new UniqueKey($field));
            }
        }
        foreach ($dbColumns as $column) {
            $table->addColumn($column);
        }

        return $table;
    }

    /**
     * @param array $data
     * @return Column[]
     */
    public function createColumns(array $data): array
    {
        $columns = [];
        /** @var Collection $column */
        foreach ($data as $column) {
            $columns[] = $this->createColumn($column->get('field'), $column);
        }

        return $columns;
    }

    public function createColumn(string $field, Collection $column): Column
    {
        $type = $column->get('type');
        $dataType = $column->get('datatype', $type);
        $autoIncrement = $column->get('auto_increment', false);
        $primaryKey = $column->get('primary_key', false);
        $unique = $column->get('unique', false);
        $length = $column->get('length', 255); // @TODO: Handle default length by type
        $default = $column->get('default_value', null);
        $unsigned = !$column->get('signed', false);
        $note = $column->get('note');
        $nullable = $column->get('required', false);

        $column = ColumnFactory::create($field, $dataType);
        $column->setNullable($nullable);
        $column->setDefault($default);
        $column->setOption('comment', $note);

        if (!$autoIncrement && $unique) {
            $column->setOption('unique', $unique);
        }

        if ($primaryKey) {
            $column->setOption('primary_key', $primaryKey);
        }

        if ($column instanceof AbstractPrecisionColumn) {
            // @TODO: handle decimal column
        } elseif ($column instanceof AbstractLengthColumn) {
            $column->setLength($length);
        } else {
            $column->setOption('length', $length);
        }

        if ($column instanceof Integer) {
            $column->setOption('autoincrement', $autoIncrement);
            $column->setOption('unsigned', $unsigned);
        }

        return $column;
    }

    public function buildTable(AbstractSql $table, $charset = '')
    {
        $connection = $this->schemaManager->getConnection();
        $sql = new Sql($connection);

        $tableQuery = $sql->buildSqlString($table);
        $tableQuery = !empty($charset) ? $tableQuery . 'charset = ' . $charset : $tableQuery;

        return $connection->query(
            $tableQuery,
            $connection::QUERY_MODE_EXECUTE
        );
    }
}
