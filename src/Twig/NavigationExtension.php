<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\NoCurrentItemFoundException;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class NavigationExtension.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationExtension extends AbstractExtension
{
    /** @var ItemHelper */
    private $helper;
    /** @var NavigationHelper */
    private $navigationHelper;

    public function __construct(ItemHelper $helper, NavigationHelper $navigationHelper)
    {
        $this->helper = $helper;
        $this->navigationHelper = $navigationHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function renderNavigation(
        Environment $environment,
        string $identifier,
        string $template = '@EverlutionNavigation/bootstrap_navigation.html.twig'
    ): string {
        return $environment->render(
            $template,
            [
                'root' => $this->navigationHelper->getNavigation($identifier)->getRoot(),
                'identifier' => $identifier,
                'helper' => $this->helper,
                'navigation_helper' => $this->navigationHelper,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function renderBreadcrumbs(
        Environment $environment,
        string $identifier,
        string $template = '@EverlutionNavigation/bootstrap_breadcrumbs.html.twig'
    ): string {
        try {
            $items = $this->navigationHelper->getNavigation($identifier)->getBreadcrumbs();
        } catch (NoCurrentItemFoundException $exception) {
            return 'missing breadcrumbs';
        }

        return $environment->render(
            $template,
            [
                'items' => $items,
                'identifier' => $identifier,
                'helper' => $this->helper,
                'navigation_helper' => $this->navigationHelper,
            ]
        );
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'render_navigation',
                [$this, 'renderNavigation'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
            new TwigFunction(
                'render_breadcrumbs',
                [$this, 'renderBreadcrumbs'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('url', [$this->helper, 'getUrl']),
        ];
    }
}
