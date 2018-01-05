<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge;

/**
 * Class AliasDoesNotExistException.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class AliasDoesNotExistException extends \Exception
{
    public function __construct(string $alias)
    {
        parent::__construct("Alias '$alias' is not registered.");
    }
}
