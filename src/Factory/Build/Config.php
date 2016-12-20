<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory\Build;

use Everlution\Navigation\Item;
use Everlution\NavigationBundle\Factory\ItemFactory;

/**
 * Class Config.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface Config
{
    /**
     * @param Item $item
     * @param ItemFactory $factory
     * @return array
     */
    public function toArray(Item $item, ItemFactory $factory): array;

    /**
     * @param array $config
     * @param ItemFactory $factory
     * @return Item
     */
    public function toObject(array $config, ItemFactory $factory): Item;
}
