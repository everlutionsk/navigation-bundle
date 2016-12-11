<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NavigationProviderCompilerPass.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationProviderCompilerPass implements CompilerPassInterface
{
    const PROVIDER_TAG = 'everlution.navigation_provider';
    const NAVIGATION_REGISTER_SERVICE = 'everlution.navigation.register';

    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(self::NAVIGATION_REGISTER_SERVICE)) {
            return;
        }

        $definition = $container->findDefinition(self::NAVIGATION_REGISTER_SERVICE);
        $this->addProviders($container, $definition);
    }

    private function addProviders(ContainerBuilder &$container, Definition &$definition)
    {
        $providers = $container->findTaggedServiceIds(self::PROVIDER_TAG);

        foreach ($providers as $id => $provider) {
            $definition->addMethodCall('register', [new Reference($id)]);
        }
    }
}
