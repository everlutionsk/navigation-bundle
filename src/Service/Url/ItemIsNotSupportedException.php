<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Service\Url;

use Everlution\Navigation\Item\ItemInterface;

/**
 * Class ItemIsNotSupportedException.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ItemIsNotSupportedException extends \Exception
{
    public function __construct(ItemInterface $item, string $supported)
    {
        $itemClass = get_class($item);
        parent::__construct("Item '$itemClass' needs to implement '$supported' interface");
    }
}
