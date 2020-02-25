<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 * Manages the Controller Features
 * @package App\Controller
 */
abstract class Controller
{
    /**
     * @var Environment|null
     */
    protected $twig = null;

    /**
     * Controller constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader('../src/View'), array('cache' => false));
    }

    /**
     * viewPage
     *
     * @param  mixed $twigpage
     *
     * @return void
     */
    public function viewPage($twigpage)
    {
            echo $twigpage;
    }
    /**
     * Redirects to another URL
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        $params['access'] = $page;
        header('Location: index.php?' . http_build_query($params));

        exit;
    }
}