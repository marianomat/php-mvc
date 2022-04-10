<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isPost()) {
            return "Handle data";
        }
        $this->setLayout("auth");
        return $this->render("login");
    }

    public function register(Request $request)
    {
        // Instanciamos un objeto modelo de registro
        $registerModel = new RegisterModel();

        if ($request->isPost()) {
            // Le pasamos los datos al modelo
            $registerModel->loadData($request->getBody());



            // Si los datos fueron validados (primera condicion)
            // Se registra el modelo (segundo condicion)
            if ($registerModel->validate() && $registerModel->register()) {
                return "Success";
            }

            // Si no cumple alguna condicion vuelve a cargar la vista de registro y se le passan los errores al usuario
            return $this->render("register", [
                "model" => $registerModel
            ]);
        }
        $this->setLayout("auth");
        return $this->render("register", [
            "model" => $registerModel
        ]);
    }
}