<?php
include 'db.php';

// Função para listar os usuários
function listarUsuarios($db) {
    $result = $db->query("SELECT * FROM usuarios");
    $usuarios = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $usuarios[] = $row;
    }
    return $usuarios;
}

// Função para adicionar um usuário
if (isset($_POST['acao']) && $_POST['acao'] == 'adicionar') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $stmt = $db->prepare("INSERT INTO usuarios (nome, email) VALUES (:nome, :email)");
    $stmt->bindValue(':nome', $nome, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Função para editar um usuário
if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $stmt = $db->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->bindValue(':nome', $nome, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Função para excluir um usuário
if (isset($_GET['acao']) && $_GET['acao'] == 'deletar') {
    $id = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Listar os usuários
$usuarios = listarUsuarios($db);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP e SQLite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Usuários</h1>

        <!-- Tabela de Usuários -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['nome'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td>
                            <button onclick="abrirModal('editar', <?= $usuario['id'] ?>, '<?= $usuario['nome'] ?>', '<?= $usuario['email'] ?>')">Editar</button>
                            <a href="?acao=deletar&id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button onclick="abrirModal('adicionar')">Adicionar Novo Usuário</button>

        <!-- Modal para adicionar ou editar usuário -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="fecharModal()">&times;</span>
                <h2 id="modal-title">Adicionar Usuário</h2>
                <form id="formModal" method="POST" action="index.php">
                    <input type="hidden" name="acao" id="acao">
                    <input type="hidden" name="id" id="userId">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" required> <br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required> <br>
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
