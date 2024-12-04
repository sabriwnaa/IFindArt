<?php

class Item implements ActiveRecord{

    private int $idItem;
    
    public function __construct(private string $titulo,private string $imagem){
    }

    public function setIdItem(int $idItem):void{
        $this->idItem = $idItem;
    }

    public function getIdItem():int{
        return $this->idItem;
    }

    public function setTitulo(string $titulo):void{
        $this->titulo = $titulo;
    }

    public function getTitulo():string{
        return $this->titulo;
    }

    public function setImagem(string $imagem):void{
        $this->imagem = $imagem;
    }

    public function getImagem():string{
        return $this->imagem;
    }


    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idItem)){
            $sql = "UPDATE Item SET titulo = '{$this->titulo}' ,imagem = '{$this->imagem}'";
        }else{
            $sql = "INSERT INTO Item (titulo,imagem,cidade,dia) VALUES ('{$this->titulo}','{$this->imagem}'";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM Item WHERE idItem = {$this->idItem}";
        return $conexao->executa($sql);
    }

    public static function findById($idItem):Item{
        $conexao = new MySQL();
        $sql = "SELECT * FROM Item WHERE idItem = {$idItem}";
        $resultado = $conexao->consulta($sql);
        $i = new Item($resultado[0]['titulo'],$resultado[0]['imagem']);
        $i->setIdItem($resultado[0]['idItem']);
        return $i;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM item";
        $resultados = $conexao->consulta($sql);
        $itens = array();
        foreach($resultados as $resultado){
            $i = new Item($resultado['titulo'],$resultado['imagem']);
            $i->setIdItem($resultado['idItem']);
            $itens[] = $i;
        }
        return $itens;
    }

    
}
