<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('everlution_navigation');

        $rootNode
            ->children()
                ->scalarNode('yaml_dir')
                ->defaultValue('%kernel.root_dir%/config/navigation')
            ->end();

        return $treeBuilder;
    }
}
