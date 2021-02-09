<?php

namespace Astrocode\Balder\Endpoints\Collections;

use Astrocode\Balder\Core\Services\TablesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collections', methods: ['POST'])]
class Create
{
    public function __invoke(Request $request, TablesService $tablesService)
    {
        $data = collect(json_decode($request->getContent(), true));

        /** @var string $name */
        $name = $data->only('name');
        /** @var array $options */
        $options = $data->only('options');

        $tablesService->createTable($name, $options);
    }
}
