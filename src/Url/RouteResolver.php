<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

use Everlution\Navigation\Uri\RouteUri;
use Everlution\Navigation\Uri\Uri;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RouteResolver.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RouteResolver implements Resolver
{
    /** @var UrlGeneratorInterface */
    private $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param Uri $uri
     * @return null|string
     */
    public function getUrl(Uri &$uri)
    {
        if ($uri instanceof RouteUri) {
            return $this->generator->generate($uri->getRoute(), $uri->getParameters());
        }

        return null;
    }
}
