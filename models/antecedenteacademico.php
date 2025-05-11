<?php
// models/antecedenteacademico.php
class AntecedenteAcademico {
    private $conn;
    private $table = "AntecedenteAcademico";

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
        $query = "INSERT INTO " . $this->table . " (candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso)
                  VALUES (:candidato_id, :institucion, :titulo_obtenido, :anio_ingreso, :anio_egreso)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':candidato_id', $data['candidato_id']);
        $stmt->bindValue(':institucion', $data['institucion']);
        $stmt->bindValue(':titulo_obtenido', $data['titulo_obtenido']);
        $stmt->bindValue(':anio_ingreso', $data['anio_ingreso']);
        $stmt->bindValue(':anio_egreso', $data['anio_egreso']);
        if ($stmt->execute()) {
            return ["message" => "Antecedente académico registrado con éxito"];
        }
        return ["message" => "Error al registrar antecedente"];
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET candidato_id = :candidato_id, institucion = :institucion,
                  titulo_obtenido = :titulo_obtenido, anio_ingreso = :anio_ingreso, anio_egreso = :anio_egreso
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':candidato_id', $data['candidato_id']);
        $stmt->bindValue(':institucion', $data['institucion']);
        $stmt->bindValue(':titulo_obtenido', $data['titulo_obtenido']);
        $stmt->bindValue(':anio_ingreso', $data['anio_ingreso']);
        $stmt->bindValue(':anio_egreso', $data['anio_egreso']);
        if ($stmt->execute()) {
            return ["message" => "Antecedente académico actualizado con éxito"];
        }
        return ["message" => "Error al actualizar antecedente"];
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return ["message" => "Antecedente académico eliminado con éxito"];
        }
        return ["message" => "Error al eliminar antecedente"];
    }
}
