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
    /** @var Helper */
    private $helper;
    /** @var AdvancedNavigationHelper */
    private $navigationHelper;

    public function __construct(Helper $helper, AdvancedNavigationHelper $navigationHelper)
    {
        $this->helper = $helper;
        $this->navigationHelper = $navigationHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function renderAdvancedNavigation(
        Environment $environment,
        string $identifier,
        string $template
    ): string {
        return $environment->render(
            $template,
            [
                'root' => $this->navigationHelper->getNavigation($identifier)->getCurrent(),
                'identifier' => $identifier,
                'helper' => $this->helper,
                'navHelper' => $this->navigationHelper,
            ]
        );
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_advanced_navigation',
                [$this, 'renderAdvancedNavigation'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }
}
