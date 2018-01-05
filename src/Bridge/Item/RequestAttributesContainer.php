<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAttributesContainer.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RequestAttributesContainer implements RequestAttributesContainerInterface
{
    /** @var Request */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
    }

    public function get(string $name, string $default = null): string
    {
        return $this->request->get($name, $default);
    }
}
