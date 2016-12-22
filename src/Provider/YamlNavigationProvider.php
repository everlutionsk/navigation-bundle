<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Provider;

use Everlution\Navigation\RootNavigationItem;
use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Provider\NavigationProvider;
use Everlution\NavigationBundle\Factory\YamlNavigationItemFactory;

/**
 * Class YamlNavigationProvider.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class YamlNavigationProvider extends NavigationProvider
{
    /** @var YamlNavigationItemFactory */
    private $factory;

    public function __construct(YamlNavigationItemFactory $factory)
    {
        $this->factory = $factory;
    }

    protected function hook(NavigationItem &$item)
    {
        $this->factory->build($item);
    }

    public function accept(RootNavigationItem &$navigation)
    {
        if (false === $this->factory->exists($navigation->getIdentifier())) {
            return;
        }

        $this->hook($navigation);
    }


    public function getName(): string
    {
        return 'yaml-navigation-provider';
    }
}
