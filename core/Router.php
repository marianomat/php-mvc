<?php

namespace app\core;

class Router
{
    public Request $request;
    protected array $routes = [];
    // Se genera un mapeo de metodos -> rutas -> callback
    // Por ejemplo, $routes["get"]["/"] = $callback, es necesario hacer un array anidado porque si no ponemos que metodo se esta ejecutando, en una ruta solo se podria utilizar un solo metodo
    // formato routes
    // $routes = [
    //    "get" => [
    //        "/" => $callback,
    //        "/contact" => $callback
    //    ],
    //    "post" => [
    //        "/contact" => $callback
    //    ]
    //]

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback) {
        // Al configurar el get, se agrega la ruta y la callback al array
        $this->routes["get"][$path] = $callback;
    }

    // Encargado de determinar el path y el metodo, luego usar la callback correspondiente segun $routes
    public function resolve()
    {
        // Usamos la clase Request que tenemos como propiedad para manejar toda la info de los request
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        // Una vez que tenemos el metodo y el path, obtenemos la callback del map
        // En caso de que no haya una callback por un path que no existe, es false.
        $callback = $this->routes[$method][$path] ?? false;

        // Si es false salimos y echo "Not Found"
        if($callback === false) {
            echo "Not Found";
            exit;
        }

        // Si existe llamamos a la funcion callback
        // call_user_func() es una funcion de PHP que ejecuta una callback
        echo call_user_func($callback);




    }
}
