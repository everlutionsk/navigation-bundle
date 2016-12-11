<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle;

use Everlution\NavigationBundle\DependencyInjection\Compiler\NavigationProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EverlutionNavigationBundle.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class EverlutionNavigationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new NavigationProviderCompilerPass());
    }

}
