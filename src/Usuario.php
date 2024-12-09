<?php

require_once "MySQL.php"; 
require_once "ActiveRecord.php";

class Usuario implements ActiveRecord {
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;

    public function __construct(string $nome, string $email, string $senha) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    // Getters and Setters
    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function setSenha(string $senha): void {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    //CRUD Usuário
    //save tem o edit e o insert junto, dependendo de como for.
    public function save(): bool {
        $this->senha = password_hash($this->senha, PASSWORD_DEFAULT); 
        $conexao = new MySQL();

        if (isset($this->idUsuario)) {
            $sql = "UPDATE Usuario SET 
                    nome = '{$conexao->escape($this->nome)}',
                    email = '{$conexao->escape($this->email)}', 
                    senha = '{$this->senha}'
                    WHERE idUsuario = {$conexao->escape($this->idUsuario)}";
        } else {
            $sql = "INSERT INTO Usuario (nome, email, senha) 
                    VALUES ('{$conexao->escape($this->nome)}', '{$conexao->escape($this->email)}', '{$this->senha}')";
        }
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM Usuario WHERE idUsuario = {$conexao->escape($this->idUsuario)}";
        return $conexao->executa($sql);
    }

    public static function findById($idUsuario): ?Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE idUsuario = {$conexao->escape($idUsuario)}";
        $resultado = $conexao->consulta($sql);

        //se não está vazio, retorna
        if (!empty($resultado)) {
            $usuario = new Usuario($resultado[0]['nome'], $resultado[0]['email'], $resultado[0]['senha']);
            $usuario->setIdUsuario($resultado[0]['idUsuario']);
            return $usuario;
        }
        return null;
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario";
        $resultados = $conexao->consulta($sql);
        $usuarios = [];

        foreach ($resultados as $resultado) {
            $usuario = new Usuario($resultado['nome'], $resultado['email'], $resultado['senha']);
            $usuario->setIdUsuario($resultado['idUsuario']);
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    // os Find By
    public static function findByEmail(string $email): ?Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE email = '{$conexao->escape($email)}'";
        $resultado = $conexao->consulta($sql);

        if (!empty($resultado)) {
            $usuario = new Usuario($resultado[0]['nome'], $resultado[0]['email'], $resultado[0]['senha']);
            $usuario->setIdUsuario($resultado[0]['idUsuario']);
            return $usuario;
        }
        return null;
    }

    public static function findByNome(string $nome): ?Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE nome = '{$conexao->escape($nome)}'";
        $resultado = $conexao->consulta($sql);

        if (!empty($resultado)) {
            $usuario = new Usuario($resultado[0]['nome'], $resultado[0]['email'], $resultado[0]['senha']);
            $usuario->setIdUsuario($resultado[0]['idUsuario']);
            return $usuario;
        }
        return null;
    }

    //Verificação de existência e login
    public static function verificarExistenciaEmail(string $email): bool {
        //não é igual a null = true
        return self::findByEmail($email) !== null;
    }

    public static function verificarExistenciaNome(string $nome): bool {
        return self::findByNome($nome) !== null;
    }

    public static function verificarLogin(string $login, string $senha): bool {
        $usuario = filter_var($login, FILTER_VALIDATE_EMAIL) 
            ? self::findByEmail($login) 
            : self::findByNome($login);

        if ($usuario && password_verify($senha, $usuario->getSenha())) {
            $_SESSION['idUsuario'] = $usuario->getIdUsuario();
            $_SESSION['nome'] = $usuario->getNome();
            return true;
        }

        $_SESSION['erro'] = $usuario ? "Senha incorreta" : "Usuário não encontrado";
        return false;
    }
}
