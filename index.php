<?php
//require_once "vendor/autoload.php";
session_start();
require_once "src/Item.php";

$itemModel = new Item();
$topItems = $itemModel->getTop3Items();

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';

if (isset($_SESSION['id'])) {
    header("Location: restrita.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mode = $_POST['mode'];

    $conn = new mysqli("localhost", "root", "", "ifindart");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($mode === 'login') {
        $login = $_POST['login'];
        $senha = $_POST['password'];

        $sql = "SELECT * FROM usuario WHERE email = ? OR nome = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['id'] = $row['idUsuario'];
                header("Location: restrita.php");
                exit();
            } else {
                $_SESSION['error'] = "Senha incorreta.";
            }
        } else {
            $_SESSION['error'] = "Usuário não encontrado.";
        }

    } elseif ($mode === 'cadastro') {
        $email = $_POST['email'];
        $nome = $_POST['nome'];

        $dominioEsperado = '@aluno.feliz.ifrs.edu.br';

        // Verificar se o e-mail é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Insira um e-mail válido.";
            header("Location: index.php?mode=cadastro");
            exit();
        } elseif (strpos($email, $dominioEsperado) === false) {
            $_SESSION['error'] = "Insira um e-mail institucional (de domínio @aluno.feliz.ifrs.edu.br).";
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $nome;
            header("Location: index.php?mode=cadastro");
            exit();
        } else {
            $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Verificar se o email ou o nome já estão cadastrados
            $sql = "SELECT * FROM usuario WHERE email = ? OR nome = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $nome);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Verifica se é o email ou o nome
                $row = $result->fetch_assoc();
                if ($row['email'] === $email) {
                    $_SESSION['error'] = "Email já cadastrado.";
                } elseif ($row['nome'] === $nome) {
                    $_SESSION['error'] = "Nome já cadastrado.";
                }
                header("Location: index.php?mode=cadastro");
                exit();
            } else {
                $sql = "INSERT INTO usuario (email, nome, senha) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $email, $nome, $senha);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $_SESSION['error'] = "Cadastro realizado com sucesso!";
                    header("Location: index.php?mode=login");
                    exit();
                } else {
                    $_SESSION['error'] = "Erro ao cadastrar o usuário.";
                 
                    header("Location: index.php?mode=cadastro");
                    exit();
                }
            }
        }
    }

    // Fechar a conexão
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFindArt</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var passwordType = passwordField.type;

            if (passwordType === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class='container'>
        <?php include 'HeaderFooter/header.php'; ?>

        <div class='main'>
            <div class='metade'>
                <div class='preView'>
                    <h2>Ranking dos artistas favoritos dos estudantes</h2>
                    <div class='itens'>
                    <?php if (!empty($topItems)) : ?>
                    <?php foreach ($topItems as $item) : ?>
                        <div class="item">
                            <h3><?php echo htmlspecialchars($item['titulo']); ?></h3>
                            <img class='fotoItem' src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="Imagem do Item">
                            <p>Votos: <?php echo (int)$item['totalVotos']; ?></p>
                        </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <p>Nenhum item foi votado ainda.</p>
                    <?php endif; ?>
                    </div>
                    <h2>...</h2>
                    <h2>Deseja ver mais do ranking e participar dele? Faça login ou cadastre-se!</h2>
                </div>
            </div>

            <div class='metade'>
                <div class='LC'>
                    <div class ='itemLC'>
                        <a href="?mode=login" >Login</a>
                    </div>
                    <div class ='itemLC'>
                        <a href="?mode=cadastro" >Cadastro</a>
                    </div>
                </div>

                <div class='box'>
                    <?php if ($mode === 'login'): ?>
                        <h2>Login</h2>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="mode" value="login">
                            <label for="login">Email ou Nome:</label>
                            <input type="text" id="login" name="login" required>
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                            <button type="submit">Entrar</button>
                        </form>
                        <p>Não tem uma conta? <a href="?mode=cadastro">Cadastre-se</a>.</p>
                    <?php else: ?>
                        <h2>Cadastro</h2>
                        
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="mode" value="cadastro">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="nome.ultimo_sobrenome@aluno.feliz.ifrs.edu.br"  required>
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" required>
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                            <button type="button" onclick="togglePassword()">Mostrar Senha</button>
                            <button type="submit">Cadastrar</button>
                        </form>
                        <p>Já tem uma conta? <a href="?mode=login">Faça login</a>.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include 'HeaderFooter/footer.php'; ?>
    </div>
</body>
</html>
