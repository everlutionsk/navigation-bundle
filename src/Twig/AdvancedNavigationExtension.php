<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\NoCurrentItemFoundException;
use Twig\Environment;

/**
 * Class AdvancedNavigationExtension
 *
 * @author Martin Lutter <martin.lutter@everlution.sk>
 */
class AdvancedNavigationExtension extends \Twig_Extension
{
    /** @var NavigationHelper */
    private $navigationHelper;
    /** @var AdvancedNavigationHelper */
    private $containerHelper;

    public function __construct(NavigationHelper $navigationHelper, AdvancedNavigationHelper $containerHelper)
    {
        $this->navigationHelper = $navigationHelper;
        $this->containerHelper = $containerHelper;
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
                'root' => $this->containerHelper->getNavigation($identifier)->getCurrent(),
                'identifier' => $identifier,
                'helper' => $this->containerHelper,
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
                'helper' => $this->navigationHelper,
            ]
        );
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_navigation',
                [$this, 'renderNavigation'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'render_breadcrumbs',
                [$this, 'renderBreadcrumbs'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('url', [$this->navigationHelper, 'getUrl']),
        ];
    }
}
