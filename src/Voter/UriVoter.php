<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter\Voter;

/**
 * Class UriVoter.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UriVoter extends RequestAware implements Voter
{
    public function match(NavigationItem $item): bool
    {
        return $this->getRequest()->getRequestUri() === $item->getUri();
    }
}
