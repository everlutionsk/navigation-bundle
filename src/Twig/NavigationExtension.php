<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Everlution\Navigation\Builder\NoCurrentItemFoundException;
use Twig\Environment;

/**
 * Class NavigationExtension.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationExtension extends \Twig_Extension
{
    /** @var NavigationHelper */
    private $helper;

    public function __construct(NavigationHelper $helper)
    {
        $this->helper = $helper;
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
                'root' => $this->helper->getNavigation($identifier)->getRoot(),
                'identifier' => $identifier,
                'helper' => $this->helper,
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
            $items = $this->helper->getNavigation($identifier)->getBreadcrumbs();
        } catch (NoCurrentItemFoundException $exception) {
            return 'missing breadcrumbs';
        }

        return $environment->render(
            $template,
            [
                'items' => $items,
                'identifier' => $identifier,
                'helper' => $this->helper,
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
            new \Twig_SimpleFilter('url', [$this->helper, 'getUrl']),
        ];
    }
}
