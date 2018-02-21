<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\Navigation\ContainerRegistry;
use Everlution\Navigation\NavBuilder\ContainerMatcherInterface;
use Everlution\Navigation\NavBuilder\NavigationBuilder;
use Everlution\Navigation\NavBuilder\NavigationContainerInterface;
use Everlution\Navigation\Item\ItemInterface;
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
class NavigationContainerHelper
{
    /** @var ContainerRegistry */
    private $registry;
    /** @var NavigationAliasContainer */
    private $aliasContainer;
    /** @var MatcherInterface */
    private $matcher;
    /** @var ContainerMatcherInterface */
    private $containerMatcher;
    /** @var NavigationBuilder[] */
    private $container = [];
    /** @var UrlProviderContainer */
    private $urlProviders;
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        ContainerRegistry $registry,
        NavigationAliasContainer $aliasContainer,
        MatcherInterface $matcher,
        ContainerMatcherInterface $containerMatcher,
        UrlProviderContainer $container,
        TranslatorInterface $translator
    ) {
        $this->registry = $registry;
        $this->aliasContainer = $aliasContainer;
        $this->matcher = $matcher;
        $this->containerMatcher = $containerMatcher;
        $this->urlProviders = $container;
        $this->translator = $translator;
    }

    public function getLabel(ItemInterface $item, string $domain = null, string $locale = null): string
    {
        $label = $item->getLabel();
        $parameters = $label instanceof TranslatableItemLabelInterface ? $label->getParameters() : [];

        return $this->translator->trans($label->getValue(), $parameters, $domain, $locale);
    }

    public function isCurrent(ItemInterface $item): bool
    {
        return $this->matcher->isCurrent($item);
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
            $this->container[$navigation] = new NavigationBuilder($container, $this->containerMatcher);
        }

        return $this->container[$navigation];
    }

    private function getContainer(string $navigation): NavigationContainerInterface
    {
        return $this->registry->getContainer($this->aliasContainer->get($navigation));
    }
}
