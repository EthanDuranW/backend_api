<?php
// models/antecedentelaboral.php
class AntecedenteLaboral {
    private $conn;
    private $table = "AntecedenteLaboral";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino)
                  VALUES (:candidato_id, :empresa, :cargo, :funciones, :fecha_inicio, :fecha_termino)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':candidato_id', $data['candidato_id']);
        $stmt->bindValue(':empresa', $data['empresa']);
        $stmt->bindValue(':cargo', $data['cargo']);
        $stmt->bindValue(':funciones', $data['funciones']);
        $stmt->bindValue(':fecha_inicio', $data['fecha_inicio']);
        if ($data['fecha_termino'] === null) {
            $stmt->bindValue(':fecha_termino', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':fecha_termino', $data['fecha_termino']);
        }
        if ($stmt->execute()) {
            return ["message" => "Antecedente laboral registrado con éxito"];
        }
        return ["message" => "Error al registrar antecedente"];
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET candidato_id = :candidato_id, empresa = :empresa, cargo = :cargo,
                  funciones = :funciones, fecha_inicio = :fecha_inicio, fecha_termino = :fecha_termino
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':candidato_id', $data['candidato_id']);
        $stmt->bindValue(':empresa', $data['empresa']);
        $stmt->bindValue(':cargo', $data['cargo']);
        $stmt->bindValue(':funciones', $data['funciones']);
        $stmt->bindValue(':fecha_inicio', $data['fecha_inicio']);
        if ($data['fecha_termino'] === null) {
            $stmt->bindValue(':fecha_termino', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':fecha_termino', $data['fecha_termino']);
        }
        if ($stmt->execute()) {
            return ["message" => "Antecedente laboral actualizado con éxito"];
        }
        return ["message" => "Error al actualizar antecedente"];
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return ["message" => "Antecedente laboral eliminado con éxito"];
        }
        return ["message" => "Error al eliminar antecedente"];
    }
}
