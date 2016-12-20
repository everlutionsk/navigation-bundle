<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory\Build\Hydrator;

use Everlution\NavigationBundle\Factory\Build\NavigationItemConfig;

/**
 * Class NavigationItem.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationItem extends NavigationItemConfig
{
    /**
     * @param string $className
     * @param array $arguments
     * @return \Everlution\Navigation\NavigationItem
     */
    protected function getObject(string $className, array $arguments)
    {
        return new $className($arguments[self::OPTION_IDENTIFIER], $arguments[self::OPTION_LABEL]);
    }

    /**
     * @param \Everlution\Navigation\NavigationItem $item
     * @return array
     */
    protected function getArray($item): array
    {
        return [
            self::OPTION_CLASS => get_class($item),
            self::OPTION_LABEL => $item->getLabel(),
            self::OPTION_IDENTIFIER => $item->getUri(),
            self::OPTION_CHILDREN => [],
        ];
    }

    protected function config()
    {
        $this->supportedClasses[] = \Everlution\Navigation\NavigationItem::class;
    }
}
