<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\NavigationBundle\DataProvider\YamlDataProvider;
use Everlution\NavigationBundle\DependencyInjection\EverlutionNavigationExtension;
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
    const YAML_PARSER_SERVICE = 'everlution.navigation.yaml_parser';
    const YAML_DATA_PROVIDER_SERVICE = 'everlution.navigation.yaml_data_provider';

    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(self::NAVIGATION_TWIG_SERVICE)) {
            return;
        }

        $definition = $container->findDefinition(self::NAVIGATION_TWIG_SERVICE);
        $this->addProviders($container, $definition);
    }

    private function addProviders(ContainerBuilder $container, Definition $definition)
    {
        $this->addYamlProvider($container);
        $providers = $container->findTaggedServiceIds(self::PROVIDER_TAG);

        foreach ($providers as $id => $provider) {
            $definition->addMethodCall('addDataProvider', [new Reference($id)]);
        }
    }

    private function addYamlProvider(ContainerBuilder $container): void
    {
        if ($container->getParameter(EverlutionNavigationExtension::PARAMETER_DISABLE_YAML_PROVIDER)) {
            return;
        }

        $definition = new Definition(YamlDataProvider::class);
        $definition
            ->addArgument(new Reference(self::YAML_PARSER_SERVICE))
            ->addArgument($container->getParameter(EverlutionNavigationExtension::PARAMETER_YAML_DIR))
            ->addArgument($container->getParameter(EverlutionNavigationExtension::PARAMETER_YAML_FILENAME_EXTENSION))
            ->addTag(self::PROVIDER_TAG);
        $container->setDefinition(self::YAML_DATA_PROVIDER_SERVICE, $definition);
    }
}
