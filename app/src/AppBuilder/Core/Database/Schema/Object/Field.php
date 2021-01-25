<?php

namespace Astrocode\AppBuilder\Core\Database\Schema\Object;

class Field extends AbstractObject
{
    public function getId()
    {
        return $this->offsetGet('id');
    }

    public function getName(): string
    {
        return $this->offsetGet('field');
    }

    public function getFormattedName(): string
    {
        return ucwords(str_replace('_', ' ', $this->get('field')));
    }

    public function getType(): string
    {
        return $this->get('type');
    }

    public function getDataType(): string
    {
        return $this->get('datatype');
    }

    public function getLength(): int
    {
        return (int) $this->get('length');
    }

    public function getColumnType(): string
    {
        return $this->get('column_type');
    }

    public function isSigned(): bool
    {
        return (bool) $this->get('signed');
    }

    /**
     * Gets field precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return (int) $this->get('precision');
    }

    /**
     * Gets field scale
     *
     * @return int
     */
    public function getScale()
    {
        return (int) $this->get('scale');
    }

    /**
     * Gets field ordinal position
     *
     * @return int
     */
    public function getSort()
    {
        return (int) $this->get('sort');
    }

    /**
     * Gets field default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->get('default_value');
    }

    /**
     * Gets whether or not the field is nullable
     *
     * @return bool
     */
    public function isNullable()
    {
        return boolval($this->get('nullable'));
    }

    /**
     * Gets the field key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->get('key');
    }

    /**
     * Gets the field extra
     *
     * @return string
     */
    public function getExtra()
    {
        return $this->get('extra');
    }

    /**
     * Gets whether or not the column has auto increment
     *
     * @return bool
     */
    public function hasAutoIncrement()
    {
        return (bool) $this->get('auto_increment', false);
    }

    /**
     * Checks whether or not the field has primary key
     *
     * @return bool
     */
    public function hasPrimaryKey()
    {
        return (bool) $this->get('primary_key', false);
    }

    /**
     * Checks whether or not the field has unique key
     *
     * @return bool
     */
    public function hasUniqueKey()
    {
        return (bool) $this->get('unique', false);
    }

    /**
     * Gets whether the field is required
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->get('required');
    }

    /**
     * Gets the interface name
     *
     * @return string
     */
    public function getInterface()
    {
        return $this->get('interface');
    }

    /**
     * Gets all or the given key options
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function getOptions($key = null)
    {
        $options = [];
        if ($this->has('options')) {
            $options = $this->get('options');
        }

        if ($key !== null && is_array($options)) {
            $options = ArrayUtils::get($options, $key);
        }

        return $options;
    }

    /**
     * Gets whether the field must be hidden in lists
     *
     * @return bool
     */
    public function isHiddenBrowse()
    {
        return $this->get('hidden_browse');
    }

    /**
     * Gets whether the field must be hidden in forms
     *
     * @return bool
     */
    public function isHiddenDetail()
    {
        return $this->get('hidden_detail');
    }

    /**
     * Gets the field comment
     *
     * @return null|string
     */
    public function getNote()
    {
        return $this->get('comment');
    }

    /**
     * Gets the field regex pattern validation string
     *
     * @return string|null
     */
    public function getValidation()
    {
        return $this->get('validation');
    }

    /**
     * Gets the collection's name the field belongs to
     *
     * @return string
     */
    public function getCollectionName()
    {
        return $this->get('collection');
    }

    /**
     * Checks whether the field is an alias
     *
     * @return bool
     */
    public function isAlias()
    {
        return DataTypes::isAliasType($this->getType());
    }

    /**
     * Checks whether this column is date system interface
     *
     * @return bool
     */
    public function isSystemDateTimeType()
    {
        return DataTypes::isSystemDateTimeType($this->getType());
    }

    /**
     * Checks whether this column is system user interface
     *
     * @return bool
     */
    public function isSystemUserType()
    {
        return DataTypes::isSystemUserType($this->getType());
    }

    /**
     * Checks whether or not the field is a status type
     *
     * @return bool
     */
    public function isStatusType()
    {
        return $this->isType(DataTypes::TYPE_STATUS);
    }

    /**
     * Checks whether or not the field is a sort type
     *
     * @return bool
     */
    public function isSortingType()
    {
        return $this->isType(DataTypes::TYPE_SORT);
    }

    /**
     * Checks whether or not the field is a date created type
     *
     * @return bool
     */
    public function isDateCreatedType()
    {
        return $this->isType(DataTypes::TYPE_DATETIME_CREATED);
    }

    /**
     * Checks whether or not the field is an user created type
     *
     * @return bool
     */
    public function isOwnerType()
    {
        return $this->isType(DataTypes::TYPE_OWNER);
    }

    /**
     * Checks whether or not the field is a date modified type
     *
     * @return bool
     */
    public function isDateModifiedType()
    {
        return $this->isType(DataTypes::TYPE_DATETIME_UPDATED);
    }

    /**
     * Checks whether or not the field is an user modified type
     *
     * @return bool
     */
    public function isUserModifiedType()
    {
        return $this->isType(DataTypes::TYPE_USER_UPDATED);
    }

    /**
     * Checks whether or not the field is a lang type
     *
     * @return bool
     */
    public function isLangType()
    {
        return $this->isType(DataTypes::TYPE_LANG);
    }

    /**
     * Checks whether or not the field is the given type
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType($type)
    {
        return strtolower($type) === strtolower($this->getType());
    }

    /**
     * Set the column relationship
     *
     * @param FieldRelationship|array $relationship
     *
     * @return Field
     */
    public function setRelationship($relationship)
    {
        // Ignore relationship information if the field is primary key
        if (!$this->hasPrimaryKey()) {
            // Relationship can be pass as an array
            if (!($relationship instanceof FieldRelationship)) {
                $relationship = new FieldRelationship($this, $relationship);
            }

            $this->relationship = $relationship;
        }

        return $this;
    }

    /**
     * Gets the field relationship
     *
     * @return FieldRelationship
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * Checks whether the field has relationship
     *
     * @return bool
     */
    public function hasRelationship()
    {
        return $this->getRelationship() instanceof FieldRelationship;
    }

    /**
     * Gets the field relationship type
     *
     * @return null|string
     */
    public function getRelationshipType()
    {
        $type = null;

        if ($this->hasRelationship()) {
            $type = $this->getRelationship()->getType();
        }

        return $type;
    }

    /**
     * Checks whether the relationship is MANY TO ONE
     *
     * @return bool
     */
    public function isManyToOne()
    {
        return $this->hasRelationship() ? $this->getRelationship()->isManyToOne() : false;
    }

    /**
     * Checks whether the relationship is ONE TO MANY
     *
     * @return bool
     */
    public function isOneToMany()
    {
        return $this->hasRelationship() ? $this->getRelationship()->isOneToMany() : false;
    }

    /**
     * Is the field being managed by Directus
     *
     * @return bool
     */
    public function isManaged()
    {
        return $this->get('managed') == 1;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        $attributes['relationship'] = $this->hasRelationship() ? $this->getRelationship()->toArray() : null;

        return $attributes;
    }
}
