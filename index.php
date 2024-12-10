<?php
require_once "vendor/autoload.php"; 

session_start();

//inicia como indesx
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';

//vai pro restrita se logado
if (isset($_SESSION['idUsuario'])) {
    header("Location: restrita.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mode = $_POST['mode'];
    $conn = new MySQL();

    if ($mode === 'login') {
        //Validação login
        if (empty($_POST['login']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Todos os campos são obrigatórios.";
            header("Location: index.php?mode=login");
            exit();
        }

        $login = $_POST['login'];
        $senha = $_POST['password'];

        if($login == 'admin' && $senha == 'ifindart'){
            header("Location: restritaAdmin.php");
            $_SESSION['adminLogado'] = true;
            exit();
        }

        if (Usuario::verificarLogin($login, $senha)) {
            
            header("Location: restrita.php");
            exit();
        } else {
            header("Location: index.php?mode=login");
            exit();
        }
    } elseif ($mode === 'cadastro') {
        //Validação cadastro
        if (empty($_POST['email']) || empty($_POST['nome']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Todos os campos são obrigatórios.";
            header("Location: index.php?mode=cadastro");
            exit();
        }

        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $senha = $_POST['password'];
        $dominioEsperado = "@aluno.feliz.ifrs.edu.br";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Insira um e-mail válido.";
        } elseif (strpos($email, $dominioEsperado) === false) {
            $_SESSION['error'] = "Insira um e-mail institucional (de domínio $dominioEsperado).";
        } elseif (Usuario::verificarExistenciaNome($nome)) {
            $_SESSION['error'] = "Nome já cadastrado.";
        } elseif (Usuario::verificarExistenciaEmail($email)) {
            $_SESSION['error'] = "E-mail já cadastrado.";
        } else {
            $novoUsuario = new Usuario($nome, $email, $senha);
            if ($novoUsuario->save()) {
                $_SESSION['success'] = "Cadastro realizado com sucesso!";
                header("Location: index.php?mode=login");
                exit();
            } else {
                $_SESSION['error'] = "Erro ao cadastrar o usuário.";
            }
        }

        header("Location: index.php?mode=cadastro");
        exit();
    }

    // Fechar a conexão, se aberta
    if (isset($conn)) {
        $conn->close();
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
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleButton = document.querySelector(".showHide");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include 'HeaderFooter/header.php'; ?>

        <div class="main">
            <div class="metade">
                <div class="preView">
                    <h2>Ranking dos artistas favoritos dos estudantes</h2>

                    <!-- aqui vem o ranking dos top 3 -->
                    <div class="itens">
                        <?php
                        $topItems = Item::getTop3Items();

                        if (!empty($topItems)) {
                            $posicao = 0;
                            foreach ($topItems as $item) {
                                $posicao++;
                                echo "
                                <div class='item' " . ($posicao === 1 ? "style='border-top: 1px solid rgb(255, 255, 255);'" : "") . ">
                                    <div class='posicao'>
                                        <h1>{$posicao}°</h1>
                                    </div>
                                    <div class='informacoes'>
                                        <div class='boxFoto'>
                                            <img class='fotoItem' src='" . htmlspecialchars($item['imagem']) . "' alt='Imagem do Item'>
                                        </div>
                                        <div class='nomeVotos'>
                                            <h3>" . htmlspecialchars($item['titulo']) . "</h3>
                                            <p>" . (int)$item['totalVotos'] . " votos</p>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p>Nenhum item foi votado ainda.</p>";
                        }
                        ?>
                    </div>

                    <div class="textoPV"><h1>...</h1></div>
                    <div class="textoPV"><p>Deseja ver mais do ranking e participar dele? Faça login ou cadastre-se!</p></div>
                </div>
            </div>

            <div class="metade">
                <div class="LC" >
                    <div class="itemLC" <?php if ($mode === 'login'){ echo ' style="background-color:#d16834;"  ';} ?>><a href="?mode=login" >Login</a></div>
                    <div class="itemLC" <?php if ($mode === 'cadastro'){ echo ' style="background-color:#d16834;"  ';} ?>><a href="?mode=cadastro">Cadastro</a></div>
                </div>

                <div class="LouC">
                    <?php if ($mode === 'login'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="mode" value="login">
                            <div class="nomeCampo">
                                <label for="login">Email ou Nome</label>
                                <input type="text" id="login" name="login" required>
                            </div>
                            <div class="nomeCampo">
                                <label for="password">Senha</label>
                                <div class="senha">
                                    <input type="password" id="password" name="password" required>
                                    <button type="button" onclick="togglePassword()" class="showHide">Show</button>
                                </div>
                            </div>
                            <button type="submit" class="logar">Entrar</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="">
                            <input type="hidden" name="mode" value="cadastro">
                            <div class="nomeCampo">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="nome.ultimo_sobrenome@aluno.feliz.ifrs.edu.br" required>
                            </div>
                            <div class="nomeCampo">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" required>
                            </div>
                            <div class="nomeCampo">
                                <label  for="password">Senha</label>
                                <div class="senha">
                                    <input type="password" id="password" name="password" required>
                                    <button type="button" onclick="togglePassword()" class="showHide">Show</button>
                                </div>
                            </div>
                            <button type="submit" class="logar">Cadastrar</button>
                        </form>
                    <?php endif; ?>

                    <!-- Mensagens de erro/sucesso -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php elseif (isset($_SESSION['success'])): ?>
                        <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include 'HeaderFooter/footer.php'; ?>
    </div>
</body>
</html>
