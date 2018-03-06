<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Twig;

use Twig\Environment;

/**
 * Class NestedNavigationExtension
 *
 * @author Martin Lutter <martin.lutter@everlution.sk>
 */
class NestedNavigationExtension extends \Twig_Extension
{
    /** @var ItemHelper */
    private $helper;
    /** @var NestedNavigationHelper */
    private $navigationHelper;

    public function __construct(ItemHelper $helper, NestedNavigationHelper $navigationHelper)
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
                'navigation_helper' => $this->navigationHelper,
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
