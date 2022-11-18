<?php

namespace App\Controllers;

//Os recursos do miniframework
use MF\Model\Container;
use MF\Controller\Action;

class AuthController extends Action {

    public function autenticar() {

        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        $usuario->autenticar();

        if($usuario->__get('id') != '' && $usuario->__get('nome') != '' && $usuario->__get('auth') == 1) {
            
            session_start();

            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');

            header('Location: /timeline');

        } else if($usuario->__get('id') != '' && $usuario->__get('nome') != '' && $usuario->__get('auth') == 0) {
            
            header('Location: /auth?email=' . $usuario->__get('email'));

        } else {
            
            header('Location: /?login=erro');

        }
    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /');
    }

}

?>