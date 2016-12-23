<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Matcher;

use Everlution\Navigation\Item;
use Everlution\Navigation\Matcher\Matcher;
use Everlution\Navigation\Voter\Matchable;
use Everlution\NavigationBundle\Voter\MatchVoter;

/**
 * Class NavigationItemMatcher.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationItemMatcher implements Matcher
{
    /** @var MatchVoter[] */
    private $voters = [];

    public function __construct(array $voters = [])
    {
        foreach ($voters as $voter) {
            $this->addVoter($voter);
        }
    }

    public function addVoter(MatchVoter $voter)
    {
        if (in_array($voter, $this->voters)) {
            throw new \Exception('Voter already registered.');
        }

        $this->voters[] = $voter;

        return $this;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isCurrent(Item $item): bool
    {
        if (!$item instanceof Matchable) {
            return false;
        }

        foreach ($this->voters as $voter) {
            if ($voter->match($item)) {
                return true;
            }
        }

        return false;
    }
}
