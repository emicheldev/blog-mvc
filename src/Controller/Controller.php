<?php
namespace App\Controller;

use App\Controller\Extension\PhpAdditionalExtension;
use App\Model\Factory\ModelFactory;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

/**
 * Class MainController
 * Manages the Main Features
 * @package App\Controller
 */
abstract class Controller extends SuperGlobalsController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;

    /**
     * @var array
     */
    private $post_content = [];

    /**
     * MainController constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        parent::__construct();

        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new PhpAdditionalExtension());
        $this->twig->addGlobal('session', filter_var_array($_SESSION));
        $this->twig->addGlobal('file', filter_var_array($_FILES));
        $this->twig->addFilter( new TwigFilter('nl2br', 'nl2br', ['is_safe' => ['html']]));
        
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

    /**
     * Redirects to another URL
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        header('Location: ' . $this->url($page, $params));
        exit;
    }

    /**
     * Renders the Views
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }

    
    /**
     * listData
     *
     * @param  mixed $value
     * @param  mixed $key
     *
     * @return void
     */
    public function listData(string $value = null, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
            return $this->database->getAllData($query, [$value]);
        }
        $query = 'SELECT * FROM ' . $this->table;
        return $this->database->getAllData($query);
    }


}