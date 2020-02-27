<?php
namespace App\Controller\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PhpAdditionalTwigExtension
 * Adds features to Twig Views
 */
class PhpAdditionalExtension extends AbstractExtension
{
    /**
     * Adds functions to Twig Views
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('url', array($this, 'url'))
        );
    }

    /**
     * Returns the Page URL
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;
        return 'index.php?' . http_build_query($params);
    }
}