<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory;

use Everlution\Navigation\Item;
use Everlution\Navigation\NavigationItem;
use Everlution\NavigationBundle\Factory\Build\UnsupportedItemClassException;
use Everlution\NavigationBundle\Navigation\FileNotExistException;
use Everlution\NavigationBundle\Factory\Build\Config;

/**
 * Class NavigationItemFactory.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
abstract class NavigationItemFactory implements ItemFactory
{
    const OPTIONS_ITEMS = 'items';

    /** @var Config[] */
    private $hydrators = [];

    public function addHydrator(Config $config)
    {
        $this->hydrators[] = $config;

        return $this;
    }

    /**
     * @param NavigationItem $navigation
     * @throws FileNotExistException
     */
    public function build(NavigationItem &$navigation)
    {
        $data = $this->getData($navigation);
        foreach ($data[self::OPTIONS_ITEMS] as $item) {
            $item = $this->create($item);
            $navigation->addChild($item);
        }
    }

    /**
     * @param array $item
     * @return Item
     */
    public function create(array $item): Item
    {
        $instance = null;
        foreach ($this->hydrators as $hydrator) {
            try {
                $instance = $hydrator->toObject($item, $this);
            } catch (UnsupportedItemClassException $exception) {
                continue;
            }
        }

        return $instance;
    }

    /**
     * @param NavigationItem $child
     * @return array
     */
    public function flatten(NavigationItem $child): array
    {
        $items = [];
        foreach ($this->hydrators as $hydrator) {
            try {
                $items[] = $hydrator->toArray($child, $this);
            } catch (UnsupportedItemClassException $exception) {
                continue;
            }
        }

        return $items;
    }

    /**
     * @param NavigationItem $navigation
     * @return array
     */
    abstract protected function getData(NavigationItem &$navigation): array;
}
