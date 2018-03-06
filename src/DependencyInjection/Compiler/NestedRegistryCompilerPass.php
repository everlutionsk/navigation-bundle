<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\Navigation\Nested\Registry;
use Everlution\NavigationBundle\Bridge\NavigationAliasContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NestedRegistryCompilerPass
 *
 * @author Martin Lutter <martin.lutter@everlution.sk>
 */
class NestedRegistryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->findDefinition(Registry::class);
        $aliasContainer = $container->findDefinition(NavigationAliasContainer::class);
        $services = $container->findTaggedServiceIds('everlution.advanced_navigation');

        foreach ($services as $id => $tags) {
            $registry->addMethodCall('addContainer', [new Reference($id)]);
            $this->addAlias($aliasContainer, $id, $tags);
        }
    }

    private function addAlias(Definition $container, string $id, array $tags)
    {
        foreach ($tags as $tag) {
            if (array_key_exists('alias', $tag)) {
                $container->addMethodCall('addAlias', [$tag['alias'], $id]);
            }
        }
    }
}
