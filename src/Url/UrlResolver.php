<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

use Everlution\Navigation\Uri\SimpleUri;
use Everlution\Navigation\Uri\Uri;

/**
 * Class UrlResolver.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UrlResolver implements Resolver
{
    /**
     * @param Uri $uri
     * @return null|string
     */
    public function getUrl(Uri &$uri)
    {
        if ($uri instanceof SimpleUri) {
            return $uri->getUri();
        }

        return null;
    }
}
