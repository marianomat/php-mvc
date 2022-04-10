<?php

namespace app\controllers;

// Los controllers manejan la logica que se ejecuta al momento que llega un request a una ruta determinada

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        // Generamos variables para pasarle a la vista
        $params = [
            "nombre" => "Mariano"
        ];
        // Pasamos el nobmre de la vista y las variables en el segundo argumento al metodo heredado de Controller
        return $this->render("home", $params);

    }

    public static function handleContact(Request $request)
    {
        // Obtiene del request el body sanitizado
        $body = $request->getBody();
        return "Handling contacto";
    }

    public static function contact()
    {
        return Application::$app->router->renderView("contact");
    }
}