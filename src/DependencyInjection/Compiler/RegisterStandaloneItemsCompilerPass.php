<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\Navigation\Item\RegistrableItemInterface;
use Everlution\Navigation\Registry;
use Everlution\NavigationBundle\Bridge\Item\Container\ItemContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterStandaloneItemsCompilerPass.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RegisterStandaloneItemsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->findDefinition(Registry::class);
        $itemsContainer = $container->findDefinition(ItemContainer::class);
        $services = $container->findTaggedServiceIds('everlution.navigation_item');

        foreach ($services as $id => $tags) {
            $itemsContainer->addMethodCall(
                'addItem',
                [$tags[0]['alias'], new Reference($id)]
            );

            $this->registerItem($id, $container, $registry);
        }
    }

    private function registerItem(string $id, ContainerBuilder $container, Definition $registry)
    {
        $definition = $container->findDefinition($id);
        $class = $definition->getClass();

        $reflectionClass = $container->getReflectionClass($class);
        if ($reflectionClass->implementsInterface(RegistrableItemInterface::class)) {
            $registry->addMethodCall('register', [new Reference($id)]);
        }
    }
}
