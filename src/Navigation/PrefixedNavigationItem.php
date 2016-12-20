<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Navigation;

use Everlution\Navigation\Item;
use Everlution\Navigation\NavigationItem;

/**
 * Class PrefixedNavigationItem.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class PrefixedNavigationItem extends NavigationItem
{
    /** @var string */
    private $prefix;

    public function __construct(string $uri, string $label, string $prefix, Item $parent = null, array $children = [])
    {
        parent::__construct($uri, $label, $parent, $children);

        $this->prefix = $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }
}
