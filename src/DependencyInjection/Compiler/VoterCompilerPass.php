<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\DependencyInjection\Compiler;

use Everlution\Navigation\Match\VoterContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class VoterCompilerPass.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class VoterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $voterContainer = $container->findDefinition(VoterContainer::class);
        $services = $container->findTaggedServiceIds('everlution.match_voter');

        foreach ($services as $id => $tags) {
            $voterContainer->addMethodCall('addVoter', [new Reference($id)]);
        }
    }
}
