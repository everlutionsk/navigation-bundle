<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Provider;

use Everlution\Navigation\Navigation;
use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Provider\NavigationProvider;
use Everlution\NavigationBundle\Navigation\NavigationItemFactory;

/**
 * Class YamlNavigationProvider.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class YamlNavigationProvider extends NavigationProvider
{
    /** @var NavigationItemFactory */
    private $factory;

    public function __construct(NavigationItemFactory $factory)
    {
        $this->factory = $factory;
    }

    protected function hook(NavigationItem &$item)
    {
        $this->factory->build($item);
    }

    public function accept(Navigation &$navigation)
    {
        if (false === $this->factory->exists($navigation->getSlug())) {
            return;
        }

        $this->hook($navigation);
    }


    public function getName(): string
    {
        return 'yaml-navigation-provider';
    }
}
