<?php

namespace Astrocode\Balder\Core\Console;

use Astrocode\Balder\Core\Database\Adapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    public function __construct(string $name = null, Adapter $adapter)
    {
        parent::__construct($name);

        dd($adapter);
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}
