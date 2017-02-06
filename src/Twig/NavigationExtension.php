<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Matcher\Matcher;
use Everlution\Navigation\Navigation\BasicNavigation;
use Everlution\Navigation\Navigation\CurrentItemNotMatchedException;
use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Provider\DataProvider;
use Everlution\Navigation\Registry\NavigationRegistry;
use Everlution\Navigation\Registry\ProviderDoesNotExist;
use Everlution\Navigation\RootNavigationItem;
use Everlution\NavigationBundle\Url\CannotResolveUrl;
use Everlution\NavigationBundle\Url\Resolver;

/**
 * Class NavigationExtension.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationExtension extends \Twig_Extension
{
    const DEFAULT_NAVIGATION_TEMPLATE = 'EverlutionNavigationBundle::navigation.html.twig';
    const DEFAULT_BREADCRUMBS_TEMPLATE = 'EverlutionNavigationBundle::breadcrumbs.html.twig';

    /** @var NavigationRegistry */
    private $registry;
    /** @var Matcher */
    private $matcher;
    /** @var BasicNavigation[] */
    private $navigationMap = [];
    /** @var Resolver */
    private $resolver;
    /** @var DataProvider[] */
    private $dataProviders = [];

    public function __construct(
        NavigationRegistry $registry,
        Matcher $matcher,
        Resolver $resolver
    ) {
        $this->registry = $registry;
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }

    /**
     * @param DataProvider $dataProvider
     * @return $this
     * @throws DataProviderAlreadyRegistered
     */
    public function addDataProvider(DataProvider $dataProvider)
    {
        if (in_array($dataProvider, $this->dataProviders)) {
            throw new DataProviderAlreadyRegistered($dataProvider);
        }

        $this->dataProviders[] = $dataProvider;

        return $this;
    }

    public function renderNavigation(
        \Twig_Environment $environment,
        string $identifier,
        string $template = self::DEFAULT_NAVIGATION_TEMPLATE
    ): string {
        return $environment->render(
            $template,
            [
                'items' => $this->getNavigation($identifier)->getRoot()->getChildren(),
                'extension' => $this,
                'identifier' => $identifier,
            ]
        );
    }

    public function renderBreadcrumbs(
        \Twig_Environment $environment,
        string $identifier,
        string $template = self::DEFAULT_BREADCRUMBS_TEMPLATE
    ): string {
        return $environment->render(
            $template,
            [
                'items' => $this->getNavigation($identifier)->getBreadcrumbs(),
                'extension' => $this,
                'identifier' => $identifier,
            ]
        );
    }

    public function getUrl(NavigationItem $item): string
    {
        try {
            $uri = $item->getUri();

            return $this->resolver->getUrl($uri);
        } catch (CannotResolveUrl $exception) {
            return "";
        }
    }

    public function isCurrent(NavigationItem $item, string $identifier): bool
    {
        try {
            return $this->getNavigation($identifier)->isCurrent($item);
        } catch (CurrentItemNotMatchedException $exception) {
            return false;
        }
    }

    public function isAncestor(NavigationItem $item, string $identifier): bool
    {
        return $this->getNavigation($identifier)->isAncestor($item);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_navigation',
                [$this, 'renderNavigation'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'render_breadcrumbs',
                [$this, 'renderBreadcrumbs'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * @param string $identifier
     * @return BasicNavigation
     */
    private function getNavigation(string $identifier): BasicNavigation
    {
        if (false === array_key_exists($identifier, $this->navigationMap)) {
            $this->navigationMap[$identifier] = new BasicNavigation($this->getRoot($identifier), $this->matcher);
        }

        return $this->navigationMap[$identifier];
    }

    /**
     * @param string $identifier
     * @return RootNavigationItem
     */
    private function getRoot(string $identifier): RootNavigationItem
    {
        foreach ($this->dataProviders as $dataProvider) {
            try {
                $root = $this->registry->getNavigation($identifier, $dataProvider);
            } catch (ProviderDoesNotExist $exception) {
                continue;
            }


            if ($root instanceof RootNavigationItem) {
                return $root;
            }
        }

        return new RootNavigationItem();
    }
}
