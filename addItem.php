<?php

session_start();
require_once "vendor/autoload.php";
require_once "src/Item.php"; // Certifique-se de incluir a classe Item

// Verifica login
if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? null;
    $imagem = $_FILES['imagem'] ?? null;

    if ($titulo && $imagem && $imagem['error'] === UPLOAD_ERR_OK) {
        // Caminho para salvar a imagem
        $uploadDir = __DIR__ . "/images/";
        $uploadFile = $uploadDir . basename($imagem['name']);
        
        // Criar diretório de upload se não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Mover a imagem para o diretório
        if (move_uploaded_file($imagem['tmp_name'], $uploadFile)) {
            // Criar novo item
            $item = new Item();
            $item->titulo = $titulo;
            $item->imagem = basename($imagem['name']); // Salva apenas o nome do arquivo

            // Salvar no banco de dados
            if ($item->save()) {
                $_SESSION['mensagem'] = "Artista cadastrado com sucesso!";
                header("Location: restritaAdmin.php");
                exit();
            } else {
                $erro = "Erro ao salvar o artista no banco de dados.";
            }
        } else {
            $erro = "Erro ao fazer upload da imagem.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos corretamente.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFindArt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class='container'>
<?php include 'HeaderFooter/header.php'; ?>
<div class='main'>

<div class='boxCadastroItem'>
    <h1 class='tituloAdmin'>Cadastrar novo artista</h1>
    <div class='camposAddItem'>
        <?php if (isset($erro)) : ?>
            <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <form action="addItem.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
            <label for="nome" style="display: flex; flex-direction: column;">
                Nome do Artista:
                <input type="text" name="titulo" id="nome" required style="padding: 10px; font-size: 16px;" />
            </label>
            <label for="imagem" style="display: flex; flex-direction: column;">
                Imagem do Artista:
                <input type="file" name="imagem" id="imagem" accept="image/*" required style="padding: 10px; font-size: 16px;" onchange="previewImage(event)" />
            </label>
            <div style="width: 150px; height: 150px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
                <img id="preview" src="#" alt="Pré-visualização" style="width: 100%;
                    height: 100%;
                    object-fit: cover; 
                    object-position: center; 
                    border-radius: 5px;" />
            </div>
            
            
    </div>
    <div class='opcoes'>
            <button type="submit" class='botaoClaro' style='flex:2;'>Cadastrar</button>
        
            <a href="restritaAdmin.php" class='botaoClaro' style='flex:1;'>Cancelar</a>
            </div>
    </form>
</div>

</div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
