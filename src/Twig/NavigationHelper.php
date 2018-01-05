<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\Navigation\Builder\NavigationBuilder;
use Everlution\Navigation\Builder\NoCurrentItemFoundException;
use Everlution\Navigation\ContainerInterface;
use Everlution\Navigation\FilteredContainer;
use Everlution\Navigation\FilteredContainerInterface;
use Everlution\Navigation\Item\ItemInterface;
use Everlution\Navigation\Registry;
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
    /** @var UrlProviderContainer */
    private $urlProviders;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        Registry $registry,
        NavigationAliasContainer $aliasContainer,
        MatcherInterface $matcher,
        UrlProviderContainer $container,
        TranslatorInterface $translator
    ) {
        $this->registry = $registry;
        $this->aliasContainer = $aliasContainer;
        $this->matcher = $matcher;
        $this->urlProviders = $container;
        $this->translator = $translator;
    }

    public function getLabel(ItemInterface $item, string $domain = null, string $locale = null): string
    {
        $label = $item->getLabel();
        $parameters = $label instanceof TranslatableItemLabelInterface ? $label->getParameters() : [];

        return $this->translator->trans($label->getValue(), $parameters, $domain, $locale);
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

    public function getUrl(ItemInterface $item): string
    {
        try {
            return $this->urlProviders->getUrl($item);
        } catch (CannotProvideUrlForItemException $exception) {
            return '#';
        }
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
