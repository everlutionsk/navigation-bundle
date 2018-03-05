<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\Navigation\Builder\NavigationBuilder;
use Everlution\Navigation\Builder\NoCurrentItemFoundException;
use Everlution\Navigation\Container\ContainerInterface;
use Everlution\Navigation\Container\FilteredContainer;
use Everlution\Navigation\Container\FilteredContainerInterface;
use Everlution\Navigation\Item\ItemInterface;
use Everlution\Navigation\Container\Registry;
use Everlution\Navigation\Url\CannotProvideUrlForItemException;
use Everlution\Navigation\Url\UrlProviderContainer;
use Everlution\NavigationBundle\Bridge\Item\TranslatableItemLabelInterface;
use Everlution\NavigationBundle\Bridge\NavigationAliasContainer;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class NavigationHelper.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationHelper
{
    /** @var Registry */
    private $registry;
    /** @var NavigationAliasContainer */
    private $aliasContainer;
    /** @var MatcherInterface */
    private $matcher;
    /** @var NavigationBuilder[] */
    private $container = [];

    public function __construct(
        Registry $registry,
        NavigationAliasContainer $aliasContainer,
        MatcherInterface $matcher
    ) {
        $this->registry = $registry;
        $this->aliasContainer = $aliasContainer;
        $this->matcher = $matcher;
    }

    public function isCurrent(string $identifier, ItemInterface $item): bool
    {
        try {
            return $this->getNavigation($identifier)->getCurrent() === $item;
        } catch (NoCurrentItemFoundException $exception) {
            return false;
        }
    }

    public function isAncestor(string $identifier, ItemInterface $item): bool
    {
        return $this->getNavigation($identifier)->isAncestor($item);
    }

    public function getNavigation(string $navigation): NavigationBuilder
    {
        if (false === array_key_exists($navigation, $this->container)) {
            $container = $this->getContainer($navigation);
            $this->container[$navigation] = new NavigationBuilder($container, $this->matcher);
        }

        return $this->container[$navigation];
    }

    private function getContainer(string $navigation): ContainerInterface
    {
        $container = $this->registry->getContainer($this->aliasContainer->get($navigation));

        if ($container instanceof FilteredContainerInterface) {
            return new FilteredContainer($container);
        }

        return $container;
    }
}
