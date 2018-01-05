<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\Navigation\Url\UrlProviderContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class UrlProviderCompilerPass.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UrlProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $providerContainer = $container->findDefinition(UrlProviderContainer::class);
        $services = $container->findTaggedServiceIds('everlution.url_provider');

        foreach ($services as $id => $tags) {
            $providerContainer->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
