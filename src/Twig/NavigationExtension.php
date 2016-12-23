<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Matcher\Matcher;
use Everlution\Navigation\Navigation\BasicNavigation;
use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Registry\NavigationRegistry;
use Everlution\NavigationBundle\Url\Resolver;

/**
 * Class NavigationExtension.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationExtension extends \Twig_Extension
{
    /** @var NavigationRegistry */
    private $registry;
    /** @var Matcher */
    private $matcher;
    /** @var BasicNavigation */
    private $navigation;
    /** @var Resolver */
    private $resolver;

    public function __construct(NavigationRegistry $registry, Matcher $matcher, Resolver $resolver)
    {
        $this->registry = $registry;
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }

    public function getNavigation(string $identifier): BasicNavigation
    {
        $root = $this->registry->getNavigation($identifier);

        if (false === $this->navigation instanceof BasicNavigation) {
            $this->navigation = new BasicNavigation($root, $this->matcher);
        }

        return $this->navigation;
    }

    public function getUrl(NavigationItem $item)
    {
        $uri = $item->getUri();

        return $this->resolver->getUrl($uri);
    }

    public function getBreadcrumbs(string $identifier): array
    {
        return $this->getNavigation($identifier)->getBreadcrumbs();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('navigation', [$this, 'getNavigation']),
            new \Twig_SimpleFunction('breadcrumbs', [$this, 'getBreadcrumbs']),
            new \Twig_SimpleFunction('get_url', [$this, 'getUrl']),
        ];
    }
}
