<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle;

use Everlution\NavigationBundle\DependencyInjection\Compiler\NestedRegistryCompilerPass;
use Everlution\NavigationBundle\DependencyInjection\Compiler\RegisterStandaloneItemsCompilerPass;
use Everlution\NavigationBundle\DependencyInjection\Compiler\RegistryCompilerPass;
use Everlution\NavigationBundle\DependencyInjection\Compiler\UrlProviderCompilerPass;
use Everlution\NavigationBundle\DependencyInjection\Compiler\VoterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EverlutionNavigationBundle.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class EverlutionNavigationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegistryCompilerPass());
        $container->addCompilerPass(new UrlProviderCompilerPass());
        $container->addCompilerPass(new VoterCompilerPass());
        $container->addCompilerPass(new RegisterStandaloneItemsCompilerPass());
    }
}
