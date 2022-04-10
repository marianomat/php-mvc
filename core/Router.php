<?php

namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
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

    public function __construct(Request $request, Response $response)
    {
        // Objeto Request;
        $this->request = $request;
        // Objeto response;
        $this->response = $response;
    }

    public function get($path, $callback) {
        // Al configurar el get, se agrega la ruta y la callback al array
        $this->routes["get"][$path] = $callback;
    }

    public function post($path, $callback)
    {
        // Al configurar el post, se agrega la ruta y la callback al array
        $this->routes["post"][$path] = $callback;
    }

    // Encargado de determinar el path y el metodo, luego usar la callback correspondiente segun $routes
    public function resolve()
    {
        // Usamos la clase Request que tenemos como propiedad para manejar toda la info de los request
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Una vez que tenemos el metodo y el path, obtenemos la callback del map
        // En caso de que no haya una callback por un path que no existe, es false.
        // Callback puede ser una funcion o el nombre de una vista (string)
        $callback = $this->routes[$method][$path] ?? false;

        // Si es una view, el callback va a ser un string
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // Si es false salimos y echo "Not Found"
        if($callback === false) {
            // Seteamos el codigo de respuesta (ambos aproach funcionan)
            //Application::$app->response->setStatusCode(404);
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        // Si no es falso, y tampoco string(view) es una callback o un array
        // En ambos casos call_user_func va a ejecutar la funcion o el metodo
        // En el caso del array, al tener el primer elemento la clase y el seugndo el metodo, se ejecuta de igual manera con el call_user_func
        // El problema es que call_user_func llama al metodo ESTATICAMENTE, por eso creamos una instancia del Controlador, apra poder usar el $this
        if(is_array($callback)) {
            // Instancaimos el controlador, el primer elemento era la clase
            // Seteamos el controller en Appliaction
            Application::$app->controller = new $callback[0]();

            // Pisamos el $callback[0] por el bojeto instanciado en vez de la claase, asi puede llamar a $this
            $callback[0] = Application::$app->controller;
        }
        // call_user_func() es una funcion de PHP que ejecuta una callback
        // Desde el segundo argumento, son los argumentos que se le van a pasar a la callback y le pasamos el request
        return call_user_func($callback, $this->request);
    }

    function renderView(string $view, $params = [])
    {
        // Acepta 2 argumentos, el nombre de la vista y un array con las variables a pasarle a la vista

        // Buscamos primero el layout
        $layoutContent = $this->layoutContent();

        // Luego el contenido de la vista
        $viewContent = $this->renderOnlyView($view, $params);


        // Cuando tenemos ambos, reempleazamos el {{content}} de layout con el contenido de la vista y lo retornamos
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }
    private function renderContent(string $viewContent)
    {
        // Renderiza el string que pasamos como argumento, por lo tanto no busca contenido de la vista porque no hay vista

        // Buscamos primero el layout
        $layoutContent = $this->layoutContent();

        // Cuando tenemos ambos, reempleazamos el {{content}} de layout con el contenido de la vista y lo retornamos
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    private function layoutContent()
    {
        // Sacamos de $app que layout usamos
        $layout = Application::$app->getController()->layout;

        // Cuando llamamos ob_start nada se muestra en el navegador
        // ob_start empieza el output caching
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php"; // (el output cacheado)
        // Retorna el valor que esta cargado/cacheado y limpia el buffer
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params) {
        // Recibe el nombre de la vista para buscarla y el array de variables para pasarle

        // Tenemos un array con variables y tenemos que pasarlas a la vista
        // Para esto iteramos por el array
        // El $$key inicializa una variable si "$key" se evalua como un nombre ("name") y el $$key se crea un nombre de variable ($name)
            //        foreach ($params as $key => $value) {
            //            $$key = $value;
            //        }
        // El include va a tener el su scope las variables declaradas

        // Encontre esta funcion que hace lo mismo que el for pero mas facil
        extract($params);

        // Cuando llamamos ob_start nada se muestra en el navegador
        // ob_start empieza el output caching
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php"; // (el output cacheado)
        // Retorna el valor que esta cargado/cacheado y limpia el buffer
        return ob_get_clean();
    }

}
