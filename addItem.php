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

    <div class="container">
        <?php include 'HeaderFooter/header.php'; ?>
        <div class="main">

            <div class="boxItem">
                <h1 class="tituloAdmin">Cadastrar novo artista</h1>
                <div class="camposItem">
                    <?php if (isset($erro)) : ?>
                        <p class="mensagemErro"><?= htmlspecialchars($erro) ?></p>
                    <?php endif; ?>
                    <form action="addItem.php" method="POST" enctype="multipart/form-data" class="formularioCadastro">
                        <label for="nome" class="labelCampo">
                            Nome do Artista:
                            <input type="text" name="titulo" id="nome" required class="inputCampo" />
                        </label>
                        <div class="custom-file">
                            <label for="imagem" class="custom-file-label">Escolha uma imagem</label>
                            <br>
                            <input type="file" name="imagem" id="imagem" accept="image/*" required class="custom-file-input" onchange="previewImage(event)" />
                        </div>
                        <div class="previewContainer">
                            <img id="preview" src="#" alt="Pré-visualização" class="previewImagem" />
                        </div>
                </div>
                <div class="opcoesCadastro">
                    <button type="submit" class="botaoClaro botaoCadastrar">Cadastrar</button>
                    <a href="restritaAdmin.php" class="botaoClaro botaoCancelar">Cancelar</a>
                </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Atualiza o texto do label ao selecionar um arquivo
        const inputFile = document.querySelector('.custom-file-input');
        const labelFile = document.querySelector('.custom-file-label');
        inputFile.addEventListener('change', (event) => {
            const fileName = event.target.files[0]?.name || 'Escolha uma imagem';
            labelFile.textContent = fileName;
        });
    </script>

</body>

</html>