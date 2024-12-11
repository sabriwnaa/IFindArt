<?php
require_once __DIR__ . "/MySQL.php";
require_once __DIR__ . "/ActiveRecord.php";

class Voto implements ActiveRecord {
    private $idVoto;

    public function __construct(private int $idUsuario, private int $idItem, private bool $isLike) {}

    public function save(): bool {
        $db = new MySQL();
        if ($this->idVoto) {
            // Atualiza voto existente
            $sql = sprintf(
                "UPDATE voto SET idUsuario = %d, idItem = %d, isLike = %d WHERE idVoto = %d",
                intval($this->idUsuario),
                intval($this->idItem),
                intval($this->isLike),
                intval($this->idVoto)
            );
        } else {
            // Insere novo voto
            $sql = sprintf(
                "INSERT INTO voto (idUsuario, idItem, isLike) VALUES (%d, %d, %d)",
                intval($this->idUsuario),
                intval($this->idItem),
                intval($this->isLike)
            );
        }

        return $db->executa($sql);
    }

    public function delete(): bool {
        if ($this->idVoto) {
            $sql = sprintf("DELETE FROM voto WHERE idVoto = %d", intval($this->idVoto));
            return (new MySQL())->executa($sql);
        }
        return false;
    }

    public static function findById($id): ?Object {
        $db = new MySQL();
        $sql = sprintf("SELECT * FROM voto WHERE idVoto = %d", intval($id));
        $result = $db->consulta($sql);

        if ($result) {
            $voto = new self($result[0]['idUsuario'], $result[0]['idItem'], $result[0]['isLike']);
            $voto->idVoto = $result[0]['idVoto'];
            return $voto;
        }
        return null;
    }

    public static function findAll(): array {
        $db = new MySQL();
        $sql = "SELECT * FROM voto";
        $results = $db->consulta($sql);

        $votos = [];
        foreach ($results as $row) {
            $voto = new self($row['idUsuario'], $row['idItem'], $row['isLike']);
            $voto->idVoto = $row['idVoto'];
            $votos[] = $voto;
        }
        return $votos;
    }

    public static function findAllByUsuario($idUsurio): array {
        $db = new MySQL();
        $sql = sprintf("SELECT * FROM voto WHERE idUsuario = %d", intval($idUsurio));
        $results = $db->consulta($sql);

        $votos = [];
        foreach ($results as $row) {
            $voto = $row['idItem'];
            $votos[] = $voto;
        }
        return $votos;
    }
}
