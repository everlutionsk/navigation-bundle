<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Item\ItemInterface;
use Everlution\Navigation\Url\CannotProvideUrlForItemException;
use Everlution\Navigation\Url\UrlProviderContainer;
use Everlution\NavigationBundle\Bridge\Item\TranslatableItemLabelInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class Helper.
 *
 * @author Martin Lutter <martin.lutter@everlution.sk>
 */
class ItemHelper
{
    /** @var TranslatorInterface */
    private $translator;
    /** @var UrlProviderContainer */
    private $urlProvider;

    public function __construct(TranslatorInterface $translator, UrlProviderContainer $urlProvider)
    {
        $this->translator = $translator;
        $this->urlProvider = $urlProvider;
    }

    public function getLabel(ItemInterface $item, string $domain = null, string $locale = null): string
    {
        $label = $item->getLabel();
        $parameters = $label instanceof TranslatableItemLabelInterface ? $label->getParameters() : [];

        return $this->translator->trans($label->getValue(), $parameters, $domain, $locale);
    }

    public function getUrl(ItemInterface $item): string
    {
        try {
            return $this->urlProvider->getUrl($item);
        } catch (CannotProvideUrlForItemException $exception) {
            return '#';
        }
    }
}
