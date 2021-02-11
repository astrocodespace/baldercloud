<?php

namespace Astrocode\Balder\Core\Database\Schema;

use Astrocode\Balder\Core\Database\Adapter;
use Astrocode\Balder\Core\Database\Exception\CollectionNotFoundException;
use Astrocode\Balder\Core\Database\Schema\Adapter\SchemaAdapter;
use Illuminate\Support\Collection;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;

class SchemaManager
{
    // CORE TABLES
    const COLLECTION_ACTIVITY = 'appbuilder_activity';
    const COLLECTION_COLLECTIONS = 'appbuilder_collections';
    const COLLECTION_FIELDS = 'appbuilder_fields';
    const COLLECTION_MIGRATIONS = 'appbuilder_migrations';
    const COLLECTION_ROLES = 'appbuilder_roles';
    const COLLECTION_PERMISSIONS = 'appbuilder_permissions';
    const COLLECTION_RELATIONS = 'appbuilder_relations';
    const COLLECTION_REVISIONS = 'appbuilder_revisions';
    const COLLECTION_SETTINGS = 'appbuilder_settings';
    const COLLECTION_USERS = 'appbuilder_users';
    const COLLECTION_WEBHOOKS = 'appbuilder_webhooks';
    const COLLECTION_USER_SESSIONS = 'appbuilder_user_sessions';

    protected $prefix = 'appbuilder_';

    /**
     * @var SchemaAdapter
     */
    private SchemaAdapter $schema;

    public function __construct(SchemaAdapter $schema)
    {
        $this->schema = $schema;
    }

    public function getCollection($name): Collection
    {
        /** @var Collection $collection */
        $collection = $this->getCollections(['name' => $name])->first();

        if (!$collection) {
            throw new CollectionNotFoundException($name);
        }

        return $collection;
    }

    public function getCollections($params = []): Collection
    {
        $collections = $this->schema->getCollections($params);

        $tables = new Collection();
        foreach ($collections as $collection) {
            $tableSchema = new Collection(
                array_merge($collection, [
                    'schema' => $this->schema->getSchemaName()
                ])
            );

            $tableName = $tableSchema->get('collection');
            $tables->offsetSet($tableName, $tableSchema);
        }

        return $tables;
    }

    public function getConnection(): \Laminas\Db\Adapter\Adapter
    {
        return $this->schema->getConnection();
    }
}
