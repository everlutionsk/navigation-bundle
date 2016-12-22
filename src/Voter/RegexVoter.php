<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter\StringVoter;
use Everlution\Navigation\Voter\Voter;
use Everlution\Navigation\RegexableItem;

/**
 * Class RegexVoter.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RegexVoter extends RequestAware implements Voter, StringVoter
{
    /**
     * @param NavigationItem $item
     * @return bool
     */
    public function match(NavigationItem $item): bool
    {
        if (!$item instanceof RegexableItem) {
            return false;
        }

        return $this->isMatch($item->getPattern());
    }

    /**
     * @param string $value
     * @return bool
     */
    public function matchString(string $value): bool
    {
        try {
            return $this->isMatch($value);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param string $value
     * @return bool
     */
    private function isMatch(string $value): bool
    {
        return 1 === preg_match($value, $this->getRequest()->getRequestUri());
    }
}
