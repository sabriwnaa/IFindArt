<?php

require_once __DIR__ . "/MySQL.php";
require_once __DIR__ . "/ActiveRecord.php";

class Item implements ActiveRecord {

    private $db;
    public $idItem;
    public $titulo;
    public $imagem;

    public function __construct() {
        $this->db = new MySQL(); 
    }

    // Método para salvar ou atualizar um item no banco de dados
    public function save(): bool {
        if ($this->idItem) {
            // Atualiza um item existente
            $sql = "UPDATE item SET titulo = '$this->titulo', imagem = '$this->imagem' WHERE idItem = $this->idItem";
        } else {
            // Insere um novo item
            $sql = "INSERT INTO item (titulo, imagem) VALUES ('$this->titulo', '$this->imagem')";
        }

        return $this->db->executa($sql);
    }

    // Método para deletar um item
    public function delete(): bool {
        if ($this->idItem) {
            $sql = "DELETE FROM item WHERE idItem = $this->idItem";
            return $this->db->executa($sql);
        }
        return false;
    }

    // Método estático para buscar um item pelo ID
    public static function findById($id): object {
        $db = new MySQL();
        $sql = "SELECT * FROM item WHERE idItem = $id";
        $result = $db->consulta($sql);

        if (!empty($result)) {
            $item = new self();
            $item->idItem = $result[0]['idItem'];
            $item->titulo = $result[0]['titulo'];
            $item->imagem = $result[0]['imagem'];
            return $item;
        }
        return null;
    }

    // Método estático para buscar todos os itens
    public static function findAll(): array {
        $db = new MySQL();
        $sql = "SELECT * FROM item";
        $results = $db->consulta($sql);

        $items = [];
        foreach ($results as $row) {
            $item = new self();
            $item->idItem = $row['idItem'];
            $item->titulo = $row['titulo'];
            $item->imagem = $row['imagem'];
            $items[] = $item;
        }
        return $items;
    }

    // Método para buscar os 3 itens mais votados
    public static function getTop3Items(): array {
        $db = new MySQL();
        $sql = "
            SELECT i.idItem, i.titulo, i.imagem, COUNT(v.idVoto) as totalVotos
            FROM item i
            LEFT JOIN voto v ON i.idItem = v.idItem
            GROUP BY i.idItem
            ORDER BY totalVotos DESC
            LIMIT 3
        ";
        return $db->consulta($sql);
    }
}

?>
