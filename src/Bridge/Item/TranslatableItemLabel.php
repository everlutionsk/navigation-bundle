<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

/**
 * Class TranslatableItemLabel.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class TranslatableItemLabel implements TranslatableItemLabelInterface
{
    /** @var string */
    private $value;
    /** @var array */
    private $parameters;

    public function __construct(string $value, array $parameters = [])
    {
        $this->value = $value;
        $this->parameters = $parameters;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
