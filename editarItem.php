<?php
session_start();
require_once "vendor/autoload.php";


if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();
}


$idItem = $_GET['idItem'] ?? null;
if (!$idItem) {
    header("Location: restritaAdmin.php");
    exit();
}


$item = Item::findById($idItem);
if (!$item) {
    die("Item não encontrado.");
}

//formulário de edição quando é por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item->titulo = $_POST['titulo'];

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/images/';
        $fileName = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadPath)) {
            $item->imagem = $fileName;
        } else {
            $error = "Erro ao fazer upload da imagem.";
        }
    }


    if ($item->save()) {
        header("Location: restritaAdmin.php?mensagem=Item atualizado com sucesso!");
        exit();
    } else {
        $error = $error ?? "Erro ao salvar o item. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<?php include 'HeaderFooter/header.php'; ?>
<div class="main">
    <div class="boxItem">
        <h1 class="tituloAdmin">Editar Item</h1>
        <?php if (isset($error)) : ?>
            <p class="mensagemErro"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <div class="camposItem">
            <form action="editarItem.php?idItem=<?= htmlspecialchars($idItem) ?>" method="POST" enctype="multipart/form-data" class="formularioCadastro">
                <label for="titulo" class="labelCampo">
                    Título do Item:
                    <input type="text" name="titulo" id="titulo" required class="inputCampo" value="<?= htmlspecialchars($item->titulo ?? '') ?>" />
                </label>
                <div class="custom-file">
                    <label for="imagem" class="custom-file-label">Nova imagem (opcional)</label>
                    <br>
                    <input type="file" name="imagem" id="imagem" accept="image/*" class="custom-file-input" onchange="previewImage(event)" />
                </div>
                <div class="previewContainer">
                    <img id="preview" src="images/<?= htmlspecialchars($item->imagem ?? 'placeholder.png') ?>" alt="Pré-visualização" class="previewImagem" />
                </div>
                
        </div>
        <div class="opcoesCadastro">
                    <button type="submit" class="botaoClaro botaoCadastrar">Salvar Alterações</button>
                    <a href="restritaAdmin.php" class="botaoClaro botaoCancelar">Cancelar</a>
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

const inputFile = document.querySelector('.custom-file-input');
const labelFile = document.querySelector('.custom-file-label');
inputFile.addEventListener('change', (event) => {
    const fileName = event.target.files[0]?.name || 'Escolha uma imagem';
    labelFile.textContent = fileName;
});
</script>
</body>
</html>
