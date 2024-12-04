<?php

class Usuario implements ActiveRecord{

    private int $idUsuario;
    
    public function __construct(private string $nome,private string $email, private String $senha){
    }

    public function getIdUsuario():int{
        return $this->idUsuario;
    }
    public function setIdUsuario(int $idUsuario):void{
        $this->idUsuario = $idUsuario;
    }

    

    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function getNome():string{
        return $this->nome;
    }

    public function setEmail(string $email):void{
        $this->email = $email;
    }

    public function getEmail():string{
        return $this->email;
    }

    public function setSenha(string $senha):void{
        $this->senha = $senha;
    }

    public function getSenha():string{
        return $this->senha;
    }

    


    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idUsuario)){
            $sql = "UPDATE Usuario SET nome = '{$this->nome}' ,email = '{$this->email}', senha = '{$this->senha}'";
        }else{
            $sql = "INSERT INTO Usuario (nome,email,senha) VALUES ('{$this->nome}','{$this->email}', '{$this->senha}'";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM Usuario WHERE idUsuario = {$this->idUsuario}";
        return $conexao->executa($sql);
    }

    public static function findById($idUsuario):Usuario{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE idUsuario = {$idUsuario}";
        $resultado = $conexao->consulta($sql);
        $u = new Usuario($resultado[0]['nome'],$resultado[0]['email'], $resultado[0]['senha']);
        $u->setIdUsuario($resultado[0]['idUsuario']);
        return $u;
    }

    public static function findByEmail(string $email):Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE idUsuario = {$email}";
        $resultado = $conexao->consulta($sql);
        $u = new Usuario($resultado[0]['nome'],$resultado[0]['email'], $resultado[0]['senha']);
        $u->setIdUsuario($resultado[0]['idUsuario']);
        return $u;
    }

    public static function verificarExistencia(string $email):bool{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario WHERE email = '{$email}'";
        $resultados = $conexao->consulta($sql);
        return count($resultados) > 0;
    }
    
    
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Usuario";
        $resultados = $conexao->consulta($sql);
        $usuarios = array();
        foreach($resultados as $resultado){
            $u = new Usuario($resultado['nome'],$resultado['email'], $resultado['senha']);
            $u->setIdUsuario($resultado['idUsuario']);
            $usuarios[] = $u;
        }
        return $usuarios;
    }

    
}
