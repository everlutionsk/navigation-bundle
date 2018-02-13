<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\NavigationBundle\Bridge\Item\Container\ItemContainerInterface;
use Twig\Environment;

/**
 * Class ItemExtension.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ItemExtension extends \Twig_Extension
{
    /** @var NavigationHelper */
    private $helper;
    /** @var ItemContainerInterface */
    private $container;
    /** @var MatcherInterface */
    private $matcher;

    public function __construct(
        NavigationHelper $helper,
        ItemContainerInterface $container,
        MatcherInterface $matcher
    ) {
        $this->helper = $helper;
        $this->container = $container;
        $this->matcher = $matcher;
    }

    public function renderItem(
        Environment $environment,
        string $name,
        string $template = '@EverlutionNavigation/bootstrap_navigation_item.html.twig'
    ): string {
        $item = $this->container->get($name);

        return $environment->render(
            $template,
            [
                'item' => $item,
                'helper' => $this->helper,
                'is_active' => $this->matcher->isCurrent($item),
            ]
        );
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_item',
                [$this, 'renderItem'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }
}
