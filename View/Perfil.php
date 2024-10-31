<?php
require_once '../config/conexao.php';

// CREATE e UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'salvar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if (empty($id)) {
        $sql = "INSERT INTO pacientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($sql);
    } else {
        $sql = "UPDATE pacientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->execute();

    header('Location: Perfil.php');
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pacientes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: Perfil.php');
    exit;
}

// Carrega os dados para edição
$paciente = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM pacientes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - CRUD de Pacientes</title>
    <link rel="stylesheet" href="../public/styleperfil.css">
</head>
<body>
    <div class="container">
        <!-- Formulário de Cadastro/Atualização -->
        <div class="form-container">
            <h2>Cadastro de Pacientes</h2>
            <form action="Perfil.php" method="post">
                <input type="hidden" name="id" value="<?php echo isset($paciente['id']) ? $paciente['id'] : ''; ?>">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo isset($paciente['nome']) ? $paciente['nome'] : ''; ?>" required>
                
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo isset($paciente['email']) ? $paciente['email'] : ''; ?>" required>
                
                <label>Telefone:</label>
                <input type="text" name="telefone" value="<?php echo isset($paciente['telefone']) ? $paciente['telefone'] : ''; ?>" required>
                
                <button type="submit" name="acao" value="salvar">Salvar</button>
            </form>
        </div>

        <!-- Tabela de Pacientes -->
        <div class="table-container">
            <h2>Lista de Pacientes</h2>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
                <?php
                $sql = "SELECT * FROM pacientes";
                $stmt = $pdo->query($sql);
                while ($paciente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$paciente['nome']}</td>";
                    echo "<td>{$paciente['email']}</td>";
                    echo "<td>{$paciente['telefone']}</td>";
                    echo "<td>
                            <a href='Perfil.php?edit={$paciente['id']}'>Editar</a> |
                            <a href='Perfil.php?delete={$paciente['id']}' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
