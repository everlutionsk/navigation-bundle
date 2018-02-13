<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item\Container;

use Everlution\Navigation\Item\ItemInterface;

/**
 * Class ItemContainer.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ItemContainer implements ItemContainerInterface
{
    private $items = [];

    public function addItem(string $name, ItemInterface $item): void
    {
        $this->items[$name] = $item;
    }

    public function get(string $name): ItemInterface
    {
        if (false === array_key_exists($name, $this->items)) {
            throw new ItemNotRegisteredException($name);
        }

        return $this->items[$name];
    }
}
