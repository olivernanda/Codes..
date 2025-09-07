<?php
session_start();
$_SESSION['score'] = 0;
$_SESSION['indice'] = 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Quiz do Conhecimento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Quiz!</h1>
        <p>Teste seus conhecimentos respondendo algumas perguntas.</p>
        <a href="Quiz.php?start=1" class="btn">Iniciar Quiz</a>
    </div>
</body>
</html>
