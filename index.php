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
        if (empty($_POST['login']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Todos os campos são obrigatórios.";
            header("Location: index.php?mode=cadastro");
            exit();
        }
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
        if (empty($_POST['email']) || empty($_POST['nome']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Todos os campos são obrigatórios.";
            header("Location: index.php?mode=cadastro");
            exit();
        }

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
    var toggleButton = document.querySelector(".showHide");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.textContent = "Hide"; // Alterar texto para "Hide"
    } else {
        passwordField.type = "password";
        toggleButton.textContent = "Show"; // Alterar texto para "Show"
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
                            <?php if (!empty($topItems)) : 
                            $posicao = 0;    
                            ?>
                            <?php foreach ($topItems as $item) : 
                                $posicao++;
                                ?>
                                
                                <div class="item" <?php if ($posicao == 1) { echo "style='border-top: 1px solid rgb(255, 255, 255);'"; } ?>>
                                    <div class='posicao'>
                                        <h1><?php echo $posicao; ?>°</h1>
                                    </div>
                                    <div class='informacoes' >
                                        <div class='boxFoto'>
                                            <img class='fotoItem' src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="Imagem do Item">
                                        </div>
                                        <div class='nomeVotos'>
                                            <h3><?php echo htmlspecialchars($item['titulo']); ?></h3>
                                            
                                            <p><?php echo (int)$item['totalVotos']; ?> votos</p>

                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                        <p>Nenhum item foi votado ainda.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class='textoPV'><h1>...</h1></div>
                    <div class='textoPV'><p>Deseja ver mais do ranking e participar dele? Faça login ou cadastre-se!</p></div>
                </div>
            </div>

            <div class='metade'>
                <div class='LC' data-color="#EB4511">
                    <div class ='itemLC'>
                        <a href="?mode=login" >Login</a>
                    </div>
                    <div class ='itemLC' data-color="#d16834">
                        <a href="?mode=cadastro" >Cadastro</a>
                    </div>
                </div>
                <script>
// Function to set active color based on mode
function setActiveColor() {
    const urlParams = new URLSearchParams(window.location.search);
    const mode = urlParams.get('mode');
    
    // Reset all items to default color
    document.querySelectorAll('.itemLC').forEach(item => {
        item.style.backgroundColor = '#ff7f3f'; // Default color
    });
    
    // Set active color based on mode
    if (mode) {
        const activeItem = Array.from(document.querySelectorAll('.itemLC')).find(item => {
            return item.querySelector('a').getAttribute('href').includes(mode);
        });
        
        if (activeItem) {
            activeItem.style.backgroundColor = '#d16834'; // Active color
        }
    }
}

// Call function on page load
setActiveColor();

// Add click event listeners to maintain color on click
document.querySelectorAll('.itemLC').forEach(item => {
    item.addEventListener('click', function() {
        // Reset all items to default color
        document.querySelectorAll('.itemLC').forEach(i => {
            i.style.backgroundColor = '#ff7f3f'; // Reset to default color
        });
        
        // Set background color to clicked item
        this.style.backgroundColor = '#d16834'; // Active color
    });
});
</script>

                <div class='LouC'>
                    <?php if ($mode === 'login'): ?>
                         <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="mode" value="login">
                            <div class='nomeCampo'>
                                <label for="login">Email ou Nome</label>
                                <input type="text" id="login" name="login" required>
                            
                            </div>
                            <div class='nomeCampo'>
                                <label for="password">Senha</label>
                                <div class='senha'>
                                
                                <input type="password" id="password" name="password" class='campoSenha' required>
                                <button type="button" onclick="togglePassword()" class='showHide'>Show</button>
                                
                            </div>
                            
                            
                            </div><button type="submit" class='logar'>Entrar</button>
                        </form>
                           <?php else: ?>
                        
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="mode" value="cadastro">
                            
                            <div class='nomeCampo'>
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="nome.ultimo_sobrenome@aluno.feliz.ifrs.edu.br"  required>
                            
                            </div>
                            <div class='nomeCampo'>
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" required>
                            
                            </div>
                            <div class='nomeCampo'>
                                <label for="password">Senha</label>
                                <div class='senha'>
                                
                                <input type="password" id="password" name="password" class='campoSenha' required>
                                <button type="button" onclick="togglePassword()" class='showHide'>Show</button>
                                
                                </div>
                            </div>
                           
                            <button type="submit" class='logar'>Cadastrar</button>
                        </form>
                        <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include 'HeaderFooter/footer.php'; ?>
    </div>
</body>
</html>
