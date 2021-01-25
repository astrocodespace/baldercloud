<?php

namespace Astrocode\AppBuilder\Endpoints\Collections;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/collections/{collectionId}', methods: ['GET'])]
class Get
{
    public function __invoke($collectionId)
    {

    }
}
