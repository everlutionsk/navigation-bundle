<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterContainerCompilerPass implements CompilerPassInterface
{
    const NAVIGATION_FILTER_CONTAINER_SERVICE = 'everlution.navigation.filter_container';

    public function process(ContainerBuilder $container)
    {
        $filterContainerDefinition = $container->findDefinition(self::NAVIGATION_FILTER_CONTAINER_SERVICE);
        $filterServices = $container->findTaggedServiceIds(self::NAVIGATION_FILTER_CONTAINER_SERVICE);

        foreach ($filterServices as $id => $filterService) {
            $filterContainerDefinition->addMethodCall('addFilter', [new Reference($id)]);
        }
    }
}
