<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        // Para poder saber que path y metodo es, podemos usar las SUPERGLOBLAS de php
        // Esta la opcion de $_SERVER donde esta toda la info
        // Dentro de $_SERVER, tenemos REQUEST_URI y PATH_INFO
        // PATH_INFO cuando el path es "/", no aparece y tampoco muestra los query params.
        // REQUEST_URI muestra el path "/" y tambien los query params
        $path = $_SERVER["REQUEST_URI"] ?? "/"; // Si por algun motivo no esta defniido REQUEST_URI, se asigna como valor "/".

        // Hay que checkear si tiene query params
        $position = strpos($path, "?"); // strpos busca el "?" en $path y devuelve la posicion, si no existe devuelve falso

        // Si no hay query params, podemos devolver el path
        // Si tiene "?", cortamos el String desde la posicion 0 hasta el $position
        if ($position === false) {
            return $path;
        } else {
            return substr($path, 0, $position);
        }
    }

    public function method()
    {
        // De $_SERVER obtenemos el metodo de REQUEST_METHOD
        // Lo retornamos en lowercase
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet()
    {
        // Si es get devuevle true y sino false
        return $this->method() === "get";
    }

    public function isPost()
    {
        // Si es post devuelve true y sino false
        return $this->method() === "post";
    }

    public function getBody()
    {
        // Accede a los datos del body de un request POST
        // Se puede acceder desde $_POST, pero puede contener caracteres maliciosos, hay que sanitizarla
        $body = [];

        // Dentro de $_GET estan los valores que envian
        // Por cada valor del GET hay que sanitizarlo
        if ($this->method() === "get") {
            foreach ($_GET as $key => $value) {
                // Filter_input  toma la variable $key, remueve los caracteres invalidos y lo devuelve dentro de body[$key]
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        // Similar al GET
        if ($this->method() === "post") {
            foreach ($_POST as $key => $value) {
                // Filter_input  toma la variable $key, remueve los caracteres invalidos y lo devuelve dentro de body[$key]
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}