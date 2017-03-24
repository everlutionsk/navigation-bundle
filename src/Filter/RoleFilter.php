<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Filter;

use Everlution\Navigation\Filter\FilterInterface;
use Everlution\Navigation\Item;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Klinec <matus.pavlik@everlution.com>
 */
class RoleFilter implements FilterInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function filterOut(Item $item): bool
    {
        return !$this->authChecker->isGranted($item->getRoles());
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isApplicable(Item $item): bool
    {
        return !empty($item->getRoles());
    }
}
