<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\NavigationBundle\Bridge\Item\Container\ItemContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterStandaloneItemsCompilerPass.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RegisterStandaloneItemsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->findDefinition(ItemContainer::class);
        $services = $container->findTaggedServiceIds('everlution.navigation_item');

        foreach ($services as $id => $tags) {
            $registry->addMethodCall(
                'addItem',
                [$tags[0]['alias'], new Reference($id)]
            );
        }
    }
}
