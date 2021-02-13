<?php

namespace Astrocode\Balder\Core\Database\Schema\Adapter\LaminasDb;

use Astrocode\Balder\Core\Database\Exception\UnprocessableEntityException\UnprocessableEntityException;
use Illuminate\Support\Collection;
use Laminas\Db\Sql\Ddl\Column\BigInteger;
use Laminas\Db\Sql\Ddl\Column\Binary;
use Laminas\Db\Sql\Ddl\Column\Blob;
use Laminas\Db\Sql\Ddl\Column\Char;
use Laminas\Db\Sql\Ddl\Column\Column;
use Laminas\Db\Sql\Ddl\Column\ColumnInterface;
use Laminas\Db\Sql\Ddl\Column\Date;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Db\Sql\Ddl\Column\Decimal;
use Laminas\Db\Sql\Ddl\Column\Floating;
use Laminas\Db\Sql\Ddl\Column\Integer;
use Laminas\Db\Sql\Ddl\Column\Text;
use Laminas\Db\Sql\Ddl\Column\Time;
use Laminas\Db\Sql\Ddl\Column\Timestamp;
use Laminas\Db\Sql\Ddl\Column\Varbinary;
use Laminas\Db\Sql\Ddl\Column\Varchar;

class ColumnFactory
{
    public const TYPES = [
        'char' => Char::class,
        'varchar' => Varchar::class,
        'text' => Text::class,
        'time' => Time::class,
        'date' => Date::class,
        'datetime' => Datetime::class,
        'timestamp' => Timestamp::class,
        'integer' => Integer::class,
        'int' => Integer::class,
        'bigint' => BigInteger::class,
        'float' => Floating::class,
        'decimal' => Decimal::class,
        'binary' => Binary::class,
        'varbinary' => Varbinary::class,
        'blob' => Blob::class,
    ];

    public static function create($name, $type): Column
    {
        if (!isset(static::TYPES[$type])) {
            throw new UnprocessableEntityException(sprintf('Type %s is not valid column type', $type));
        }
        $typeClass = static::TYPES[$type];
        return new $typeClass($name);
    }

}
