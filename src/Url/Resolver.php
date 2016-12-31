<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

use Everlution\Navigation\Uri\Uri;

/**
 * Interface Resolver.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface Resolver
{
    /**
     * @param Uri $uri
     * @return string
     * @throws CannotResolveUrl
     */
    public function getUrl(Uri &$uri);
}
