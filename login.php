<?php
$conexao = new mysqli("localhost", "root", "", "academia");
$conexao->set_charset("utf8");

$treinos = null;
$aluno = null;
$erro = "";

if (isset($_POST['buscar'])) {
    $cpf = $_POST['cpf'];

    $aluno = $conexao->query("SELECT nome FROM alunos WHERE cpf = '$cpf'")->fetch_assoc();

    if ($aluno) {
        $treinos = $conexao->query("
            SELECT dia_semana, treino 
            FROM treinos 
            WHERE cpf_aluno = '$cpf'
            ORDER BY FIELD(dia_semana,'Segunda','Terça','Quarta','Quinta','Sexta','Sábado')
        ");
    } else {
        $erro = "CPF não encontrado no sistema.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Consultar Treino</title>

<style>
    body{
        margin:0;
        background:#111;
        color:#fff;
        font-family:Arial;
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

    .container{
        max-width:600px;
        margin:60px auto;
        padding:20px;
        background:#1a1a1a;
        border-radius:10px;
        box-shadow:0 0 20px rgba(255,0,0,0.25);
    }

    h1{
        text-align:center;
        color:#e03636;
        margin-bottom:20px;
    }

    input{
        width:100%;
        padding:12px;
        margin-top:10px;
        background:#222;
        border:none;
        border-radius:6px;
        color:#fff;
        box-sizing:border-box;
    }

    button{
        width:100%;
        padding:12px;
        margin-top:15px;
        background:#e03636;
        border:none;
        border-radius:6px;
        font-weight:bold;
        color:#fff;
        cursor:pointer;
    }

    button:hover{
        background:#ff4545;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:20px;
    }

    th, td{
        padding:12px;
        border-bottom:1px solid #333;
    }

    th{
        background:#e03636;
    }

    .erro{
        margin-top:10px;
        color:#ff4444;
        text-align:center;
        font-weight:bold;
    }
</style>
</head>

<body>

<a href="index.html" class="back-btn">← Voltar</a>

<div class="container">

    <h1>Consultar Treino</h1>

    <form method="POST">
        <input type="text" name="cpf" placeholder="Digite seu CPF..." required>
        <button type="submit" name="buscar">Buscar Treino</button>
    </form>

    <?php if ($erro): ?>
        <p class="erro"><?= $erro ?></p>
    <?php endif; ?>

    <?php if ($aluno): ?>
        <h1 style="font-size:22px; margin-top:30px;">
            Treinos de <?= $aluno['nome'] ?>
        </h1>

        <table>
            <tr>
                <th>Dia</th>
                <th>Treino</th>
            </tr>

            <?php while ($t = $treinos->fetch_assoc()): ?>
            <tr>
                <td><?= $t['dia_semana'] ?></td>
                <td><?= $t['treino'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
