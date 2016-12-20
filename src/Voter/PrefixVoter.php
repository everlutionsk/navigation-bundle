<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter\Voter;
use Everlution\NavigationBundle\Navigation\PrefixedNavigationItem;

/**
 * Class PrefixVoter.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class PrefixVoter extends RequestAware implements Voter
{
    /**
     * @param NavigationItem $item
     * @return bool
     */
    public function match(NavigationItem $item): bool
    {
        if (!$item instanceof PrefixedNavigationItem) {
            return false;
        }

        return 0 === strpos($this->getRequest()->getRequestUri(), $item->getPrefix());
    }
}
