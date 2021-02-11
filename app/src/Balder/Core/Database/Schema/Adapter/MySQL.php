<?php

namespace Astrocode\Balder\Core\Database\Schema\Adapter;

use Astrocode\Balder\Core\Database\Adapter;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;

class MySQL implements SchemaAdapter
{
    /**
     * @var Adapter
     */
    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getSchemaName(): string
    {
        return $this->adapter->getCurrentSchema();
    }

    public function getCollections(array $params = []): iterable
    {
        $select = new Select();
        $select->columns([
            'collection' => 'TABLE_NAME',
            'created_at' => 'CREATE_TIME',
            'collation' => 'TABLE_COLLATION',
            'schema_comment' => 'TABLE_COMMENT'
        ]);
        $select->from(['ST' => new TableIdentifier('TABLES', 'INFORMATION_SCHEMA')]);

        $select->where([
            'TABLE_SCHEMA' => $this->adapter->getCurrentSchema(),
            'TABLE_TYPE' => 'BASE TABLE'
        ]);

        if (isset($params['name'])) {
            $tableName = $params['name'];
            $where = $select->where->nest();
            $where->equalTo('ST.TABLE_NAME', $tableName);
            $where->OR;
            $where->equalTo('ST.TABLE_NAME', $tableName);
            $where->unnest();
        }

        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        return $statement->execute();
    }

    public function getConnection(): Adapter
    {
        return $this->adapter;
    }
}
