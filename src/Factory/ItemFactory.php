<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory;

use Everlution\Navigation\Item;
use Everlution\Navigation\NavigationItem;
use Everlution\NavigationBundle\Navigation\FileNotExistException;

/**
 * Class NavigationItemFactory.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface ItemFactory
{
    /**
     * @param NavigationItem $navigation
     * @throws FileNotExistException
     */
    public function build(NavigationItem &$navigation);

    /**
     * @param array $item
     * @return Item
     */
    public function create(array $item): Item;

    /**
     * @param NavigationItem $child
     * @return array
     */
    public function flatten(NavigationItem $child): array;
}
