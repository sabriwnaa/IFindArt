<?php
require_once __DIR__ . "/MySQL.php";
require_once __DIR__ . "/ActiveRecord.php";

class Item implements ActiveRecord {
    private $db;
    public $idItem, $titulo, $imagem;

    public function __construct() {
        $this->db = new MySQL();
    }

    public function save(): bool {
        if ($this->idItem) {
            // Monta a query para atualização
            $sql = sprintf(
                "UPDATE item SET titulo = '%s', imagem = '%s' WHERE idItem = %d",
                $this->db->escape($this->titulo),
                $this->db->escape($this->imagem),
                intval($this->idItem)
            );
        } else {
            // Monta a query para inserção
            $sql = sprintf(
                "INSERT INTO item (titulo, imagem) VALUES ('%s', '%s')",
                $this->db->escape($this->titulo),
                $this->db->escape($this->imagem)
            );
        }
        // Executa a query
        return $this->db->executa($sql);
    }
    

    public function delete(): bool {
        if ($this->idItem) {
            $sql = "DELETE FROM item WHERE idItem = ?";
            return $this->db->executa($sql, [$this->idItem]);
        }
        return false;
    }

    public static function findById($id): ?Object {
        $db = new MySQL();
        $sql = "SELECT * FROM item WHERE idItem = ?";
        $result = $db->consulta($sql, [$id]);

        if ($result) {
            $item = new self();
            $item->idItem = $result[0]['idItem'];
            $item->titulo = $result[0]['titulo'];
            $item->imagem = $result[0]['imagem'];
            return $item;
        }
        return null;
    }

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

    public static function getItemAleatorio(array $idsVotados): ?array {
        $db = new MySQL();
        $sql = "SELECT * FROM item";
    
        // Adiciona a cláusula WHERE apenas se houver IDs votados
        if (!empty($idsVotados)) {
            $ids = implode(',', array_map('intval', $idsVotados));
            $sql .= " WHERE idItem NOT IN ($ids)";
        }
    
        $sql .= " ORDER BY RAND() LIMIT 1";
    
        $result = $db->consulta($sql);
    
        return $result[0] ?? null;
    }
    

    public static function getRankingCompleto(): array {
        $db = new MySQL();
        $sql = "
            SELECT i.idItem, i.titulo, i.imagem, COUNT(v.idVoto) AS totalVotos
            FROM item i
            LEFT JOIN voto v ON i.idItem = v.idItem AND v.isLike = 1
            GROUP BY i.idItem
            ORDER BY totalVotos DESC";
        return $db->consulta($sql);
    }

    public static function getTop3Items(): array {
        $db = new MySQL();
        $sql = "
            SELECT i.idItem, i.titulo, i.imagem, COUNT(v.idVoto) AS totalVotos
            FROM item i
            LEFT JOIN voto v ON i.idItem = v.idItem AND v.isLike = 1
            GROUP BY i.idItem
            ORDER BY totalVotos DESC
            LIMIT 3
        ";
        return $db->consulta($sql);
    }

    public static function findAllSorted(): array {
        $db = new MySQL();
        $sql = "
            SELECT i.idItem, i.titulo, i.imagem, COUNT(v.idVoto) AS totalVotos
            FROM item i
            LEFT JOIN voto v ON i.idItem = v.idItem AND v.isLike = 1
            GROUP BY i.idItem
            ORDER BY i.titulo ASC
        ";
        return $db->consulta($sql);
    }
    
}
