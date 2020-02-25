<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\RegisterController;
use Exception;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Class Router
 * Manages Routes to show Views
 * @package App
 */
class Router
{
    /**
     * run
     *
     * @return void
     */
    public function run()
    {
       try {
        if (isset($_GET['route'])) {
            if ($_GET['route'] === 'register') {
                $registerController= new RegisterController;
                 $registerController->create();
            } else {
                 echo 'page inconnue';
            }
        }
        else{
            $homeController= new HomeController;
             $homeController->home();
        }
       } catch (Exception $e) {
        echo 'Erreur';
       }
    }


}