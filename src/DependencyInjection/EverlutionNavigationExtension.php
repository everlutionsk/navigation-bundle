<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection;

use Everlution\NavigationBundle\DataProvider\YamlDataProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class EverlutionNavigationBundleExtension.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class EverlutionNavigationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['disable_yaml_provider']) {
            $container->setParameter('everlution.navigation.yaml_dir', $config['yaml_dir']);
            $container->autowire(YamlDataProvider::class)->addTag('everlution.navigation_data_provider');
        }

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
