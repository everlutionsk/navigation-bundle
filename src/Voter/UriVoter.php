<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter\StringVoter;
use Everlution\Navigation\Voter\Voter;

/**
 * Class UriVoter.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UriVoter extends RequestAware implements Voter, StringVoter
{
    /**
     * @param NavigationItem $item
     * @return bool
     */
    public function match(NavigationItem $item): bool
    {
        return $this->matchString($item->getUri());
    }

    /**
     * @param string $value
     * @return bool
     */
    public function matchString(string $value): bool
    {
        return $this->getRequest()->getRequestUri() === $value;
    }
}
