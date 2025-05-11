<?php
// models/postulacion.php
class Postulacion {
    private $conn;
    private $table = "Postulacion";

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
        $query = "INSERT INTO " . $this->table . " (candidato_id, oferta_laboral_id, estado_postulacion, comentario)
                  VALUES (:candidato_id, :oferta_laboral_id, 'Postulando', '')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':candidato_id', $data['candidato_id']);
        $stmt->bindValue(':oferta_laboral_id', $data['oferta_laboral_id']);
        if ($stmt->execute()) {
            return ["message" => "Postulación registrada con éxito"];
        }
        return ["message" => "Error al registrar postulación"];
    }

 public function update($id, $data) {
    // Verificar si la postulación existe
    $checkQuery = "SELECT id FROM Postulacion WHERE id = :id";
    $checkStmt = $this->conn->prepare($checkQuery);
    $checkStmt->bindParam(':id', $id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() == 0) {
        http_response_code(404);
        return ["message" => "Postulacion no encontrada"];
    }

    // Si existe, proceder a actualizar
    $query = "UPDATE Postulacion SET estado_postulacion = :estado_postulacion, comentario = :comentario WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':estado_postulacion', $data['estado_postulacion']);
    $stmt->bindParam(':comentario', $data['comentario']);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        return ["message" => "Postulación actualizada con exito"];
    }
    return ["message" => "Error al actualizar postulacion"];
}


    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return ["message" => "Postulación eliminada con exito"];
        }
        return ["message" => "Error al eliminar postulación"];
    }
}