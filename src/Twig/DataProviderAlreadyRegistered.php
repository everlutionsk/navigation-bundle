<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Provider\DataProvider;

/**
 * Class DataProviderAlreadyRegistered.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class DataProviderAlreadyRegistered extends \Exception
{
    public function __construct(DataProvider $dataProvider)
    {
        parent::__construct(
            sprintf("Data provider '%s' already registered.", get_class($dataProvider))
        );
    }
}
