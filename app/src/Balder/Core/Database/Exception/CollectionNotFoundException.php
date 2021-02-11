<?php

namespace Astrocode\Balder\Core\Database\Exception;

use Exception;
use Throwable;

class CollectionNotFoundException extends Exception
{
    public function __construct($name)
    {
        parent::__construct(sprintf('Collection %s does not exists', ucfirst($name)));
    }
}
