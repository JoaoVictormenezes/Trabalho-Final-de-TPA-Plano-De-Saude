<?php
namespace Model;

require_once __DIR__ . '/../config/conexao.php';

class UsuarioModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrar($nome, $email, $senha)
    {
        $sql = "INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha); 

        return $stmt->execute();
    }

    public function login($email, $senha)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

    
        if ($usuario && $usuario['senha'] === $senha) {
            return $usuario;
        }

        return false;
    }
}

?>
