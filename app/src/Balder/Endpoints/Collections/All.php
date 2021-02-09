<?php

namespace Astrocode\Balder\Endpoints\Collections;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collections', methods: ['GET'])]
class All extends AbstractController
{
    public function __invoke()
    {
        return new Response('test');
    }
}
