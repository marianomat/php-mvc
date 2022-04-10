<?php

namespace app\core;

class Application
{
    // Para poder acceder a la instancia de $app en toda la aplicacion
    public static Application $app;
    // Guardamos estaticamente el path del root de la aplicacion
    public static string $ROOT_DIR;
    // Las clases request, router, db son parte de la app, por eso las ponemos como propiedades para que puedan ser accedidas desde cualquier lugar
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;


    public function __construct($rootPath)
    {
        // Guardamos la instancia de $app en la clase
        self::$app = $this;
        // Generamos una propiedad estatica que indica el path root de la aplicacion
        self::$ROOT_DIR = $rootPath;
        // Al crear el objeto Applaction creamos el objeto Request
        $this->request = new Request();
        // Objeto response;
        $this->response = new Response();
        // Al crear el objeto Applaction creamos el objeto Router y le pasamos la instancia de Request y Response
        $this->router = new Router($this->request, $this->response);
    }


    public function run()
    {
        // Ejecutar resolve dentro del router que se encarga de determinar el path y el metodo
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

}