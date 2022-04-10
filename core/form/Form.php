<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    // Se crea esta clase para poder hacer los formularios y las validaciones de una manera mas limpia

    // Inicio del formulario, echo del form y devuelve una instancia del Form
    public static function begin($action, $method)
    {
        // sprintf es como C
        echo sprintf("<form action='%s' method='%s' >", $action, $method);
        return new Form();
    }

    public function field(Model $model, $attribute)
    {

        return new Field($model, $attribute);
    }

    public static function end()
    {
        echo "</form>";
    }
}