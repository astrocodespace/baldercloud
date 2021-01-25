<?php

namespace Astrocode\AppBuilder\Core\Database\Schema\Object;

use Illuminate\Support\Collection;

abstract class AbstractObject extends Collection
{
    /**
     * @var Collection
     */
    protected $attributes = [];

    public function __construct(array $attributes)
    {
        $this->attributes = new Collection($attributes);
    }
}
