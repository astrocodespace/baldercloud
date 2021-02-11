<?php

namespace Astrocode\Balder\Core\Console;

use Astrocode\Balder\Core\Database\Adapter;
use Astrocode\Balder\Core\Services\TablesService;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';
    /**
     * @var TablesService
     */
    private TablesService $tablesService;

    public function __construct(string $name = null, TablesService $tablesService)
    {
        parent::__construct($name);

        $this->tablesService = $tablesService;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->tablesService->createTable('1' , 'test', new Collection([
            [
                'field' => 'id',
                'type' => 'integer',
                'datatype' => 'int',
                'length' => 11,
                'interface' => 'numeric',
                'primary_key' => true
            ],
        ]));
        return Command::SUCCESS;
    }
}
