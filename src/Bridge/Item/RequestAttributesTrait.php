<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

/**
 * Trait RequestAttributesTrait.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
trait RequestAttributesTrait
{
    /** @var RequestAttributesContainerInterface */
    private $attributeContainer;

    public function __construct(RequestAttributesContainerInterface $attributeContainer)
    {
        $this->attributeContainer = $attributeContainer;
    }

    private function copyRequestParameters(array $parameters): array
    {
        $result = [];
        foreach ($parameters as $parameter) {
            $result[$parameter] = $this->attributeContainer->get($parameter);
        }

        return $result;
    }
}
