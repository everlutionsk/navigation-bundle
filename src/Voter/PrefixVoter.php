<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter\StringVoter;
use Everlution\Navigation\Voter\Voter;
use Everlution\Navigation\PrefixableItem;

/**
 * Class PrefixVoter.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class PrefixVoter extends RequestAware implements Voter, StringVoter
{
    /**
     * @param NavigationItem $item
     * @return bool
     */
    public function match(NavigationItem $item): bool
    {
        if (!$item instanceof PrefixableItem) {
            return false;
        }

        return $this->matchString($item->getPrefix());
    }

    /**
     * @param string $value
     * @return bool
     */
    public function matchString(string $value): bool
    {
        return 0 === strpos($this->getRequest()->getRequestUri(), $value);
    }
}
