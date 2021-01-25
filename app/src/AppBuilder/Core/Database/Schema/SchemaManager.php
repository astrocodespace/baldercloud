<?php

namespace Astrocode\AppBuilder\Core\Database\Schema;

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
}
