<?php

namespace app\core;

// Creamos la clase controlles a la que va a darle metodos utiles a los controllers hijos
class Controller
{
    // El layout por defecto es siempre main
    public string $layout = "main";
    // Este metodo hace que el controler pueda tener el metood para renderizar views de una manera mas practica con $this->render en vez de Application::clas...
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

}