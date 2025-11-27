<?php
$conexao = new mysqli("localhost", "root", "", "academia");

if ($conexao->connect_error) {
    die("Erro ao conectar: " . $conexao->connect_error);
}

//  EXCLUIR ALUNO
if (isset($_GET['del'])) {
    $cpf = $_GET['del'];

    $sql = $conexao->prepare("DELETE FROM alunos WHERE cpf = ?");
    $sql->bind_param("s", $cpf);
    $sql->execute();
    $sql->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

//  ADICIONAR ALUNO
if (isset($_POST['novo_aluno'])) {
    $nome     = $_POST['nome'];
    $cpf      = $_POST['cpf'];
    $plano    = $_POST['plano'];
    $idade    = $_POST['idade'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = $conexao->prepare(
        "INSERT INTO alunos (cpf, nome, plano, idade, email, telefone) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );


    $sql->bind_param("ssssss", $cpf, $nome, $plano, $idade, $email, $telefone);

    if (!$sql->execute()) {
        echo "Erro ao inserir: " . $sql->error;
    }

    $sql->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

//  LISTAR ALUNOS
$alunos = $conexao->query("SELECT * FROM alunos ORDER BY cpf DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Alunos</title>

<style>
    body{
        margin:0;
        font-family:Arial, sans-serif;
        background:#111;
        color:#fff;
    }

    .back-btn{
        position:absolute;
        top:15px;
        left:15px;
        padding:10px 18px;
        background:#e03636;
        color:#fff;
        text-decoration:none;
        font-weight:bold;
        border-radius:6px;
        transition:0.2s;
    }
    .back-btn:hover{
        background:#ff4545;
    }

    .delete-btn {
        color: #ff4444;
        font-weight: bold;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 4px;
        background: #220000;
        border: 1px solid #ff4444;
        transition: 0.2s;
    }
    .delete-btn:hover {
        background: #ff0000;
        color: #fff;
    }

    .container{
        max-width:900px;
        margin:70px auto;
        padding:20px;
        background:#1a1a1a;
        border-radius:10px;
        box-shadow:0 0 20px rgba(255,0,0,0.2);
    }
    h1{
        text-align:center;
        margin-bottom:20px;
        color:#e03636;
    }
    form{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-bottom:25px;
    }
    input, select{
        padding:10px;
        flex:1 1 180px;
        border:none;
        border-radius:5px;
        background:#222;
        color:#fff;
    }
    button{
        padding:10px 20px;
        background:#e03636;
        border:none;
        border-radius:5px;
        color:#fff;
        cursor:pointer;
        font-weight:bold;
    }
    table{
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }
    th, td{
        padding:12px;
        text-align:left;
        border-bottom:1px solid #333;
    }
    th{
        background:#e03636;
    }
</style>

</head>
<body>

<a href="index.php" class="back-btn">← Voltar</a>

<div class="container">

    <h1>Painel Alunos</h1>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome do aluno" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <input type="number" name="idade" placeholder="Idade" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="telefone" placeholder="Telefone" required> 
        <select name="plano">
            <option value="Silver">Silver</option>
            <option value="Gold">Gold</option>
            <option value="Titanium">Titanium</option>
        </select>
        <button type="submit" name="novo_aluno">Adicionar</button>
    </form>

    <table>
        <tr>
            <th></th>
            <th>Aluno</th>
            <th>CPF</th>
            <th>Plano</th>
            <th>Idade</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>

        <?php if($alunos && $alunos->num_rows > 0): ?>
            <?php while($row = $alunos->fetch_assoc()): ?>
            <tr>
                <td>
                    <a class="delete-btn" href="?del=<?= $row['cpf'] ?>" 
                       onclick="return confirm('Tem certeza que deseja excluir este aluno?')">X</a>
                </td>
                
                <td><?= $row['nome'] ?></td>
                <td><?= $row['cpf'] ?></td>
                <td><?= $row['plano'] ?></td>
                <td><?= $row['idade'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['telefone'] ?></td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="7">Nenhum aluno cadastrado.</td></tr>
        <?php endif; ?>

    </table>

</div>

</body>
</html>
