<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Provider;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Provider\NavigationProvider;
use Everlution\NavigationBundle\Navigation\NavigationItemFactory;

/**
 * Class YamlNavigationProvider.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class YamlNavigationProvider extends NavigationProvider
{
    /** @var string */
    private $name;
    /** @var NavigationItemFactory */
    private $factory;

    public function __construct(string $name, NavigationItemFactory $factory)
    {
        $this->name = $name;
        $this->factory = $factory;
    }

    protected function hook(NavigationItem &$item)
    {
        $navigation = $this->factory->build($this->getName());
    }

    public function getName(): string
    {
        return $this->name;
    }
}
