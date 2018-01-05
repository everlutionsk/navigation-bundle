<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class Configuration implements ConfigurationInterface
{
    const CONFIG_ROUTER_SERVICE = 'router_service';

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('everlution_navigation');

        $rootNode
            ->children()
                ->scalarNode(self::CONFIG_ROUTER_SERVICE)->defaultValue('router.default')->end()
            ->end();

        return $treeBuilder;
    }
}
