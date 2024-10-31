<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="../controller/UsuarioController.php"  method="post">
            <label for="email">EMAIL:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">SENHA:</label>
            <input type="password" id="senha" name="senha" required>
            
            <button type="submit">ENVIAR</button>
            <a href="Cadastro.php">Cadastrar</a>
        </form>
    </div>
</body>
</html>
