<?php
namespace Controller;

require_once __DIR__ . '/../model/UsuarioModel.php';
use Model\UsuarioModel;

class UsuarioController
{
    private $usuarioModel;

    public function __construct($pdo)
    {
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function cadastrar()
    {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if ($this->usuarioModel->cadastrar($nome, $email, $senha)) {
            header('Location: ../view/Login.php?');
        } else {
            header('Location: ../view/Cadastro.php?');
        }
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuario = $this->usuarioModel->login($email, $senha);

        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: ../view/Perfil.php');
        } else {
            header('Location: ../view/Login.php?erro=Usuário ou senha inválidos');
        }
    }
}

require_once __DIR__ . '/../config/conexao.php';
$controller = new UsuarioController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'])) {
        $controller->cadastrar();
    } else {
        $controller->login();
    }
}
?>
