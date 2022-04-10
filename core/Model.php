<?php

namespace app\core;

// Es abstracta para evitar crear una instancia de esta clase, obliga a tener subclase para que se instancie
abstract class Model
{
    // Reglas
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";

    // Array de errores
    public array $errors = [];


    // Load data carga los datos en las propiedades del objeto ModelXX, si bien Model no tiene propeidades
    // Model es una clase padre a la que van a extender clases que si tengan propiedades y a esas  se les va a asignar
    public function loadData($data)
    {
        // Lo que hace es iterar por el array $data
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)){ // Checkea si existe la propiedad $key en el objeto $this
                $this->{$key} = $value; // Si existe le da valor a la propiedad del objeto con el $value
            }
        }
    }

    // Metodo abstracto que debe ser implementado en los modelos hijos, devuelve un array
    abstract public function rules(): array;


    // Cada modelo debe tener sus reglas de validacion, el metodo validate utiliza las reglas contra los valores de las propeidades
    public function validate()
    {
        // Hay que iterar sobre las reglas que estan declaradas en la clase hijo
        // Cada atributo tiene un array de reglas
        foreach ($this->rules() as $attribute => $rules) {
            // Buscamos el valor de la propiedad
            // Si tenemos la propiedad $firstName = "mariano" , $value va a ser "mariano"
            // Ya con el valor de la variable, se comprueba que se cumplan las reglas
            $value = $this->{$attribute};
            // Hay que iterar sobre las reglas
            foreach ($rules as $rule) {
                // Cada regla puede ser un string o un array
                $ruleName = $rule;

                // $rule es "required" o es un array ["min", "min" => 10]

                if (!is_string($ruleName)) {
                    // Si es un array, el primer elemento indica el nombre de regla
                    $ruleName = $rule[0];
                }

                // Verificacion si es "required" y si tiene valor
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    // Si no hay valor, generamos un error
                    // Agregamos el error al array de errores, con el nombre del atributo y la regla
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                // Verifica si es un email y con el fiter_var le pasamos el varlor y el segundo argumento el filtro que checkea si es un email
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                // Verifica el minimo, si el valor de strlen (vallue) es menor que lo seteado en $rule["min"]
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule["min"]) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                // Verifica el maximo, si el valor de strlen (vallue) es mayor que lo seteado en $rule["max"]
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                // Verifica el match
                // [self::RULE_MATCH, ["match" => "password]
                // Si el valor de la propiedad $value, no coincide con el valor de la propiedad que matchea $this->password, genera error
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule["match"]}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }

        }
        // Si no hay errores devuelve true, si hay errores devuelve false
        return empty($this->errors);
    }

    // Metodo encargado de agregar un error al array de errores
    private function addError(string $attribute, string $rule, $params = [])
    {
        // Busca el mensaje en errorMessage, si no hay devuelve un string vacio
        $message = $this->errorMessage()[$rule] ?? "";

        // Si tenemos parametros tenemos que agregarlos al mensage
        // Ejemplo para mostrar cuantos son los caracteres minimos, ya que es una cantidad variable que se setea en el modelo
        foreach ($params as $key => $value) {
            // Reempleaza el {min} que esta en el mensaje, por el valor del min
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    // Metodo que setea el mensaje a mostrar al usuario en caso de que se produzca
    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => "Este campo es requerido",
            self::RULE_MAX => "Sólo {max} caracteres máximos aceptados",
            self::RULE_MIN => "Cantidad mínima de caracteres {min}",
            self::RULE_EMAIL => "El campo debe contener un email válido",
            self::RULE_MATCH => "El campo debe coincidir con {match}"
        ];
    }

    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? "";
    }

    public function getFirstError(string $attribute)
    {
        // No entendi muy bien este
        return $this->errors[$attribute][0] ?? "";
    }
}