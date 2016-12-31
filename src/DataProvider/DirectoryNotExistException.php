<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DataProvider;

/**
 * Class DirectoryNotExistException.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class DirectoryNotExistException extends \Exception
{
    public function __construct(string $directory)
    {
        parent::__construct(
            sprintf("Directory '%s' does not exist.", $directory)
        );
    }
}
