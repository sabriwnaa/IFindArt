<?php

class Voto implements ActiveRecord{

    private int $idVoto;
    
    public function __construct(private int $idUsuario,private int $idItem, private bool $isLike){
    }

    public function setIdVoto(int $idVoto):void{
        $this->idUsuario = $idVoto;
    }

    public function getIdVoto():int{
        return $this->idVoto;
    }

    public function setIdUsuario(int $idUsuario):void{
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario():int{
        return $this->idUsuario;
    }


    public function setIdItem(int $idItem):void{
        $this->idItem = $idItem;
    }

    public function getIdItem():int{
        return $this->idItem;
    }

    public function setIsLike(bool $isLike):void{
        $this->isLike = $isLike;
    }

    public function getIsLike():bool{
        return $this->isLike;
    }

    


    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idUsuario)){
            $sql = "UPDATE Voto SET idUsuario = '{$this->idUsuario}' ,idItem = '{$this->idItem}', isLike = '{$this->isLike}'";
        }else{
            $sql = "INSERT INTO Voto (idUsuario,idItem,cidade,dia) VALUES ('{$this->idUsuario}','{$this->idItem}', '{$this->isLike}'";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM Voto WHERE idVoto = {$this->idVoto}";
        return $conexao->executa($sql);
    }

    public static function findById($idVoto):Voto{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Voto WHERE idVoto = {$idVoto}";
        $resultado = $conexao->consulta($sql);
        $v = new Voto($resultado[0]['idUsuario'],$resultado[0]['idItem'], $resultado[0]['isLike']);
        $v->setIdVoto($resultado[0]['idVoto']);
        return $v;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Voto";
        $resultados = $conexao->consulta($sql);
        $votos = array();
        foreach($resultados as $resultado){
            $v = new Voto($resultado['idUsuario'],$resultado['idItem'], $resultado['isLike']);
            $v->setIdVoto($resultado['idVoto']);
            $votos[] = $v;
        }
        return $votos;
    }

    
}
