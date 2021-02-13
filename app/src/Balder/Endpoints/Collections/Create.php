<?php

namespace Astrocode\Balder\Endpoints\Collections;

use Astrocode\Balder\Core\Services\TablesService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collections', methods: ['POST'])]
class Create
{
    public function __invoke(Request $request)
    {
        $data = collect(json_decode($request->getContent(), true));

        /** @var string $name */
        $name = $data->only('name');
        /** @var array $options */
        $options = $data->only('options');

        file_put_contents('test.json', json_encode($request->getContent()));
//        $tablesService->createTable($name, $options);

        return new JsonResponse();
    }
}
