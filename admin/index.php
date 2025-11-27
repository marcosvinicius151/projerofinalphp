<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Admin — Academia</title>
<style>
    body{
        margin:0;
        padding:0;
        background:#111;
        color:#fff;
        font-family:Arial, sans-serif;
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
    }
    .box{
        background:#1a1a1a;
        padding:30px;
        border-radius:10px;
        text-align:center;
        width:300px;
        box-shadow:0 0 20px rgba(255,0,0,0.2);
    }
    h1{
        color:#e03636;
        margin-bottom:20px;
    }
    a{
        display:block;
        text-decoration:none;
        background:#e03636;
        color:#fff;
        padding:12px;
        border-radius:6px;
        margin:10px 0;
        font-weight:bold;
        transition:0.2s;
    }
    a:hover{
        background:#ff4a4a;
    }
</style>
</head>
<body>

<div class="box">
    <h1>Painel Admin</h1>

    <a href="painel_alunos.php">Gerenciar Alunos</a>
    <a href="painel_treino.php">Gerenciar Treinos</a>
</div>

</body>
</html>
