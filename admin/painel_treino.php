<?php
$conexao = new mysqli("localhost", "root", "", "academia");
$conexao->set_charset("utf8");


if (isset($_POST['salvar'])) {
    $cpf_aluno = $_POST['cpf_aluno'];
    $dias = $_POST['dia'];
    $treinos = $_POST['treino'];


    $conexao->query("DELETE FROM treinos WHERE cpf_aluno = '$cpf_aluno'");


    foreach ($dias as $index => $dia) {
        $treino = $treinos[$index];
        $sql = "INSERT INTO treinos (cpf_aluno, dia_semana, treino) 
                VALUES ('$cpf_aluno', '$dia', '$treino')";
        $conexao->query($sql);
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


$alunos = $conexao->query("SELECT cpf, nome FROM alunos ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Treinos</title>

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
        flex-direction:column;
        gap:20px;
    }

    select, input{
        padding:10px;
        width:100%;
        background:#222;
        border:none;
        border-radius:6px;
        color:#fff;
    }

    button{
        padding:12px;
        background:#e03636;
        color:#fff;
        border:none;
        font-weight:bold;
        border-radius:6px;
        cursor:pointer;
    }
    button:hover{
        background:#ff4545;
    }

    .dia-box{
        padding:10px;
        background:#151515;
        border-left:3px solid #e03636;
        border-radius:6px;
    }

    label{
        font-weight:bold;
        color:#ccc;
    }
</style>

</head>
<body>

<a href="index.php" class="back-btn">← Voltar</a>

<div class="container">

<h1>Painel de Treinos</h1>

<form method="POST">

    <div>
        <label>Selecione o Aluno:</label>
        <select name="cpf_aluno" required>
            <option value="">Escolha um aluno</option>
            <?php while ($a = $alunos->fetch_assoc()): ?>
                <option value="<?= $a['cpf'] ?>"><?= $a['nome'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <h1 style="font-size:22px;">Treinos por Dia da Semana</h1>

    <?php
    $dias_semana = ["Segunda","Terça","Quarta","Quinta","Sexta","Sábado"];
    foreach ($dias_semana as $dia):
    ?>

    <div class="dia-box">   
        <label><?= $dia ?></label>
        <input type="hidden" name="dia[]" value="<?= $dia ?>">

        <select name="treino[]" required>
            <option value="">Selecione</option>
            <option value="Peito e Tríceps">Peito e Tríceps</option>
            <option value="Costas e Bíceps">Costas e Bíceps</option>
            <option value="Ombro">Ombro</option>
            <option value="Perna">Perna</option>
        </select>
    </div>

    <?php endforeach; ?>

    <button type="submit" name="salvar">Salvar Treinos</button>
</form>

</div>

</body>
</html>