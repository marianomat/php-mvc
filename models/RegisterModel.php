<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $firstName = "";
    public string $lastName = "";
    public string $email = "";
    public string $password = "";
    public string $passwordConfirm = "";

    public function register()
    {
        echo "Nuevo usuario";
        return true;
    }

    // Se setean las reglas que debe tener el modelo
    // Devuelve un array asociativo de propiedad -> regla,
    // Las reglas pueden ser solo un elemento o un array en caso de necesitar mas datos (MIN, MAX, MATCH)
    public function rules(): array
    {
        return [
            "firstName" => [self::RULE_REQUIRED],
            "lastName" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 8], [self::RULE_MAX, "max" => 24]],
            // Match es un array, donde en el segundo elemento se establece a que otra propeidad debe matchear
            "passwordConfirm" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]]
        ];
    }
}