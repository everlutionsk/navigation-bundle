<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory;

/**
 * Class FileNotExistException.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class FileNotExistException extends \Exception
{
    public function __construct(string $filename)
    {
        parent::__construct(
            sprintf("File '%s' does not exist.", $filename)
        );
    }
}
