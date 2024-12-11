<?php
session_start();
require_once "vendor/autoload.php";

if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();
}

$idItem = $_GET['id'];
$item = Item::findById($idItem);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item->titulo = $_POST['titulo'];
    $item->imagem = $_POST['imagem'];
    if ($item->save()) {
        header("Location: restritaAdmin.php");
        exit();
    } else {
        $error = "Erro ao salvar o item.";
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
    <div class="camposItem">
        <?php if (isset($erro)) : ?>
            <p class="mensagemErro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <form action="editarItem.php" method="POST" enctype="multipart/form-data" class="formularioCadastro">
            <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
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
