<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NavigationDataProviderCompilerPass.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationDataProviderCompilerPass implements CompilerPassInterface
{
    const PROVIDER_TAG = 'everlution.navigation_data_provider';
    const NAVIGATION_TWIG_SERVICE = 'everlution.navigation.twig_extension';

    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(self::NAVIGATION_TWIG_SERVICE)) {
            return;
        }

        $definition = $container->findDefinition(self::NAVIGATION_TWIG_SERVICE);
        $this->addProviders($container, $definition);
    }

    private function addProviders(ContainerBuilder &$container, Definition &$definition)
    {
        $providers = $container->findTaggedServiceIds(self::PROVIDER_TAG);

        foreach ($providers as $id => $provider) {
            $definition->addMethodCall('addDataProvider', [new Reference($id)]);
        }
    }
}
