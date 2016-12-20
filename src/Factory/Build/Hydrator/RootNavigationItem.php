<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory\Build\Hydrator;

use Everlution\NavigationBundle\Factory\Build\NavigationItemConfig;

/**
 * Class RootNavigationItem.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RootNavigationItem extends NavigationItemConfig
{
    const OPTION_CHILDREN = 'items';

    /**
     * @param string $className
     * @param array $arguments
     * @return \Everlution\Navigation\NavigationItem
     */
    protected function getObject(string $className, array $arguments)
    {
        return new \Everlution\Navigation\RootNavigationItem('', '');
    }

    /**
     * @param \Everlution\Navigation\NavigationItem $item
     * @return array
     */
    protected function getArray($item): array
    {
        return [];
    }

    protected function config()
    {
        $this->supportedClasses[] = \Everlution\Navigation\RootNavigationItem::class;
    }
}
