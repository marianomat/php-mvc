<?php

namespace app\core;

class Application
{
    // Las clases request, router, db son parte de la app, por eso las ponemos como propiedades para que puedan ser accedidas desde cualquier lugar
    public Router $router;
    public Request $request;

    public function __construct()
    {
        // Al crear el objeto Applaction creamos el objeto Request
        $this->request = new Request();
        // Al crear el objeto Applaction creamos el objeto Router y le pasamos la instancia de Request
        $this->router = new Router($this->request);

    }

    public function run()
    {
        // Ejecutar resolve dentro del router que se encarga de determinar el path y el metodo
        return $this->router->resolve();
    }
}