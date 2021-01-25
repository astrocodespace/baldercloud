<?php

namespace Astrocode\ZendDbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('zend-db');

        $treeBuilder
            ->getRootNode()
            ->children();
//            ->arrayNode()
    }

}
