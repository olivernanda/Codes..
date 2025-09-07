<?php

session_start();

$perguntas = [
    [
        "pergunta" => "Qual linguagem é usada para estruturar páginas web?",
        "opcoes" => ["CSS", "HTML", "Python"],
        "correta" => 1
    ],
    [
        "pergunta" => "Qual comando exibe algo no console do JavaScript?",
        "opcoes" => ["echo", "console.log", "print"],
        "correta" => 1
    ],
    [
        "pergunta" => "O que significa PHP?",
        "opcoes" => ["Personal Home Page", "Private Hosting Protocol", "Python Hypertext Preprocessor"],
        "correta" => 0
    ]
];



// Reinicia pelo link ?start=1
if (isset($_GET['start'])) {
    $_SESSION['score'] = 0;
    $_SESSION['indice'] = 0;
}

$perguntas = [
    [
        "pergunta" => "Qual linguagem é usada para estruturar páginas web?",
        "opcoes" => ["CSS", "HTML", "Python"],
        "correta" => 1
    ],
    [
        "pergunta" => "Qual comando exibe algo no console do JavaScript?",
        "opcoes" => ["echo", "console.log", "print"],
        "correta" => 1
    ],
    [
        "pergunta" => "O que significa PHP?",
        "opcoes" => ["PHP: Hypertext Preprocessor", "Personal Home Page", "Public Home Page"],
        "correta" => 0
    ],
];

if (!isset($_SESSION['indice'])) {
    $_SESSION['indice'] = 0;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

$feedback = "";
$feedbackClass = "";
$mostraFeedback = false;

// Trata as ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'answer';
    $indiceAtual = $_SESSION['indice'];

    if ($action === 'answer') {
        // Garantia: ainda dentro do range
        if ($indiceAtual < count($perguntas)) {
            $resposta = isset($_POST['resposta']) ? intval($_POST['resposta']) : -1;

            if ($resposta === $perguntas[$indiceAtual]['correta']) {
                $_SESSION['score']++;
                $feedback = "✅ Resposta correta!";
                $feedbackClass = "ok";
            } else {
                $corretaTxt = $perguntas[$indiceAtual]['opcoes'][$perguntas[$indiceAtual]['correta']];
                $feedback = "❌ Resposta incorreta. A correta era: <b>" . htmlspecialchars($corretaTxt) . "</b>";
                $feedbackClass = "err";
            }
            // Exibe feedback da pergunta atual e só avança quando clicar em "Próxima"
            $mostraFeedback = true;
        }
    } elseif ($action === 'next') {
        // Avança para a próxima pergunta
        $_SESSION['indice']++;
    }
}

// Atualiza o índice depois das ações
$indice = $_SESSION['indice'];

// Se terminou, mostra resultado
if ($indice >= count($perguntas)) {
    $score = $_SESSION['score'];
    $total = count($perguntas);
    // Limpa sessão se quiser recomeçar depois
    session_unset();
    session_destroy();
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Resultado</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h2>Fim do Quiz!</h2>
            <p>Sua pontuação foi <strong><?php echo $score; ?></strong> de <strong><?php echo $total; ?></strong>.</p>
            <a href="index.php" class="btn">Recomeçar</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Caso ainda haja perguntas, mostra a tela de pergunta/feedback
$pergunta = $perguntas[$indice];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script src="quiz.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Pergunta <?php echo ($indice + 1); ?> de <?php echo count($perguntas); ?></h2>
        <p><?php echo htmlspecialchars($pergunta['pergunta']); ?></p>

        <?php if ($mostraFeedback): ?>
            <p class="feedback <?php echo $feedbackClass; ?>"><?php echo $feedback; ?></p>
            <form method="POST" action="Quiz.php">
                <input type="hidden" name="action" value="next">
                <button type="submit" class="btn">Próxima</button>
            </form>
        <?php else: ?>
            <form method="POST" action="Quiz.php">
                <?php foreach ($pergunta['opcoes'] as $i => $opcao): ?>
                    <label>
                        <input type="radio" name="resposta" value="<?php echo $i; ?>" required>
                        <?php echo htmlspecialchars($opcao); ?>
                    </label><br>
                <?php endforeach; ?>
                <input type="hidden" name="action" value="answer">
                <button type="submit" class="btn">Responder</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
