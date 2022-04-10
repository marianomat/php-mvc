<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

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
        if ($request->isPost()) {
            return "Handle data";
        }
        return $this->render("register");
    }
}