<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item\Container;

use Everlution\Navigation\Item\ItemInterface;

/**
 * Interface ItemContainerInterface.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface ItemContainerInterface
{
    public function addItem(string $name, ItemInterface $item): void;

    /**
     * @param string $name
     *
     * @return ItemInterface
     *
     * @throws ItemNotRegisteredException
     */
    public function get(string $name): ItemInterface;
}
