<?php

namespace App\Controller;

//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;

class LoginController extends BaseController {

    public function login() {
        return $this->render('LoginPage/base.html.twig');
    }

}