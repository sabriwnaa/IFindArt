<?php

require_once __DIR__ . "\Configuracao.php";

class MySQL {

    private $connection;

    public function __construct() {
        $this->connection = new \mysqli(HOST, USUARIO, SENHA, BANCO);

        if ($this->connection->connect_error) {
            die("Erro de conexão: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8");
    }

    public function executa($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Erro na execução do SQL: " . $this->connection->error);
        }
        return $result;
    }

    public function executaPreparado($sql, $params) {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Erro na preparação do SQL: " . $this->connection->error);
        }

        if ($params) {
            $stmt->bind_param(...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function consulta($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Erro na consulta: " . $this->connection->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

?>
