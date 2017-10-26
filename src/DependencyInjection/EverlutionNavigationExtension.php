<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EverlutionNavigationBundleExtension.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class EverlutionNavigationExtension extends Extension
{
    const PARAMETER_YAML_DIR = 'everlution.navigation.yaml_dir';
    const PARAMETER_DISABLE_YAML_PROVIDER = 'everlution.navigation.disable_yaml_provider';
    const PARAMETER_YAML_FILENAME_EXTENSION = 'everlution.navigation.yaml_filename_extension';

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_YAML_DIR, $config['yaml_dir']);
        $container->setParameter(self::PARAMETER_DISABLE_YAML_PROVIDER, $config['disable_yaml_provider']);
        $container->setParameter(self::PARAMETER_YAML_FILENAME_EXTENSION, $config['yaml_filename_extension']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}