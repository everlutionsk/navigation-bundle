<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\Navigation\Advanced\ContainerRegistry;
use Everlution\Navigation\Advanced\Builder\NavigationBuilder;
use Everlution\Navigation\Advanced\Item\AdvancedNavigationInterface;
use Everlution\Navigation\Item\ItemInterface;
use Everlution\NavigationBundle\Bridge\NavigationAliasContainer;

/**
 * Class AdvancedNavigationHelper
 *
 * @author Martin Lutter <martin.lutter@everlution.sk>
 */
class AdvancedNavigationHelper
{
    /** @var ContainerRegistry */
    private $registry;
    /** @var NavigationAliasContainer */
    private $aliasContainer;
    /** @var MatcherInterface */
    private $matcher;
    /** @var NavigationBuilder[] */
    private $container = [];

    public function __construct(
        ContainerRegistry $registry,
        NavigationAliasContainer $aliasContainer,
        MatcherInterface $matcher
    ) {
        $this->registry = $registry;
        $this->aliasContainer = $aliasContainer;
        $this->matcher = $matcher;
    }

    public function isCurrent(ItemInterface $item): bool
    {
        return $this->matcher->isCurrent($item);
    }

    public function getNavigation(string $navigation): NavigationBuilder
    {
        if (false === array_key_exists($navigation, $this->container)) {
            $container = $this->getContainer($navigation);
            $this->container[$navigation] = new NavigationBuilder($container, $this->matcher);
        }

        return $this->container[$navigation];
    }

    private function getContainer(string $navigation): AdvancedNavigationInterface
    {
        return $this->registry->getContainer($this->aliasContainer->get($navigation));
    }
}
