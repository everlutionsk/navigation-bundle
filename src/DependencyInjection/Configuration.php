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
            ->booleanNode('disable_yaml_provider')->defaultFalse()->end()
            ->scalarNode('yaml_dir')->defaultValue('%kernel.root_dir%/config/navigation')->end()
            ->scalarNode('yaml_filename_extension')->defaultValue('yaml')->end()
            ->end();

        return $treeBuilder;
    }
}
