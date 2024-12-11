<?php
require_once __DIR__ . "/MySQL.php";
require_once __DIR__ . "/ActiveRecord.php";

class Item implements ActiveRecord {
    private $db;
    public $idItem, $titulo, $imagem;

    public function __construct(string $titulo = '', string $imagem = '') {
        $this->db = new MySQL();
        $this->titulo = $titulo;
        $this->imagem = $imagem;
    }

    // Salva ou atualiza um item no banco de dados
    public function save(): bool {
        if ($this->idItem) {
            
            $sql = sprintf(
                "UPDATE item SET titulo = '%s', imagem = '%s' WHERE idItem = %d",
                $this->db->escape($this->titulo),
                $this->db->escape($this->imagem),
                intval($this->idItem)
            );
        } else {
            
            $sql = sprintf(
                "INSERT INTO item (titulo, imagem) VALUES ('%s', '%s')",
                $this->db->escape($this->titulo),
                $this->db->escape($this->imagem)
            );
        }

        return $this->db->executa($sql);
    }

    // Exclui o item e seus votos relacionados
    public function delete(): bool {
        if ($this->idItem) {
            $id = intval($this->idItem);

            // Exclui votos relacionados ao item
            $sqlVotos = "DELETE FROM voto WHERE idItem = $id";
            $this->db->executa($sqlVotos);

            // Exclui o item
            $sqlItem = "DELETE FROM item WHERE idItem = $id";
            return $this->db->executa($sqlItem);
        }
        return false;
    }


    public function getIdItem(): int {
        return $this->idItem;
    }

    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getImagem(): string {
        return $this->imagem;
    }

    public function setImagem(string $imagem): void {
        $this->imagem = $imagem;
    }

    public static function findById($id): ?Item {
        $conexao = new MySQL();
        $id = intval($id);
        $sql = "SELECT * FROM item WHERE idItem = $id";
        $resultado = $conexao->consulta($sql);

        if (!empty($resultado)) {
            $item = new Item($resultado[0]['titulo'], $resultado[0]['imagem']);
            $item->setIdItem($resultado[0]['idItem']);
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
            LIMIT 3";
        return $db->consulta($sql);
    }


    public static function findAllSorted(): array {
        $db = new MySQL();
        $sql = "
            SELECT i.idItem, i.titulo, i.imagem, COUNT(v.idVoto) AS totalVotos
            FROM item i
            LEFT JOIN voto v ON i.idItem = v.idItem AND v.isLike = 1
            GROUP BY i.idItem
            ORDER BY i.titulo ASC";
        return $db->consulta($sql);
    }
}
