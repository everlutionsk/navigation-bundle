<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Matcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAware.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
abstract class RequestAware
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
