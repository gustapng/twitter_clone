<?php

namespace App\Controllers;

//Os recursos do miniframework
use MF\Model\Container;
use MF\Controller\Action;

//Recurso Helper função
use App\Helpers\FunctionsStr;
use App\Helpers\FunctionsSendEmail;

class IndexController extends Action {

	public function auth() {

		session_start();

		$_SESSION['email'] = $_GET['email'];

		$this->render('auth');
	}

	public function validaToken() {

		session_start();

		$user = Container::getModel('Usuario');

		$user->__set('email', $_SESSION['email']);

		$tokenBanco = $user->selectToken();

		$user->__set('token', $tokenBanco['token']);

		if($_POST['tokenEnviado'] == $tokenBanco['token']) {
			
			$senha = $user->recuperaSenha();
			$id = $user->recuperaId();
			$nome = $user->recuperaNome();
			$auth = $user->recuperaAuth();
			$user->__set('senha', md5($senha['senha']));
			$user->__set('id', ($id['id']));
			$user->__set('nome', ($nome['nome']));
			$user->__set('auth', ($auth['auth']));

			if($user->__get('id') != '' && $user->__get('nome') != '' && $user->__get('auth') == 0) {
            
				$user->authEmail();
				session_start();
	
				$_SESSION['id'] = $user->__get('id');
				$_SESSION['nome'] = $user->__get('nome');
	
				header('Location: /timeline');
	
			}
			
		} else {

			Header('Location: /auth?email=' . $_SESSION['email'] . '&tentativa=erro');
		}
		
	}

	public function index() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {
		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => ''
		);


		$this->view->erroCadastro = false;
		$this->render('inscreverse');
	}

	public function registrar() {

		$usuario = Container::getModel('Usuario');

		$numAleatorio = FunctionsStr::randValues(6);

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));
		$usuario->__set('token', $numAleatorio);

		if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {

			FunctionsSendEmail::sendEmail($usuario->__get('email'), $usuario->__get('token'));

			$usuario->salvar();
			$this->render('cadastro');

		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);

			$this->view->erroCadastro = true;

			$this->render('inscreverse');
		}

	}

	
}

?>