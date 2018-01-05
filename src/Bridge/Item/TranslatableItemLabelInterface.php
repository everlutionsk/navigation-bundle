<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

use Everlution\Navigation\Item\ItemLabelInterface;

/**
 * Interface TranslatableItemLabelInterface.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface TranslatableItemLabelInterface extends ItemLabelInterface
{
    public function getParameters(): array;
}
