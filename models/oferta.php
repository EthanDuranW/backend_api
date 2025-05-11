<?php
// models/oferta.php
class Oferta {
    private $conn;
    private $table = "OfertaLaboral";

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
    $query = "INSERT INTO " . $this->table . " 
        (titulo, descripcion, ubicacion, salario, tipo_contrato, fecha_cierre, reclutador_id, estado)
        VALUES 
        (:titulo, :descripcion, :ubicacion, :salario, :tipo_contrato, :fecha_cierre, :reclutador_id, 'vigente')";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':titulo', $data['titulo']);
    $stmt->bindParam(':descripcion', $data['descripcion']);
    $stmt->bindParam(':ubicacion', $data['ubicacion']);
    $stmt->bindParam(':salario', $data['salario']);
    $stmt->bindParam(':tipo_contrato', $data['tipo_contrato']);
    $stmt->bindParam(':fecha_cierre', $data['fecha_cierre']);
    $stmt->bindParam(':reclutador_id', $data['reclutador_id']);

    if ($stmt->execute()) {
        return ["message" => "Oferta registrada con éxito"];
    }
    return ["message" => "Error al registrar oferta"];
}



    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET titulo = :titulo, descripcion = :descripcion, ubicacion = :ubicacion,
                  salario = :salario, tipo_contrato = :tipo_contrato, fecha_cierre = :fecha_cierre
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':titulo', $data['titulo']);
        $stmt->bindValue(':descripcion', $data['descripcion']);
        $stmt->bindValue(':ubicacion', $data['ubicacion']);
        $stmt->bindValue(':salario', $data['salario']);
        $stmt->bindValue(':tipo_contrato', $data['tipo_contrato']);
        $stmt->bindValue(':fecha_cierre', $data['fecha_cierre']);
        if ($stmt->execute()) {
            return ["message" => "Oferta actualizada con éxito"];
        }
        return ["message" => "Error al actualizar oferta"];
    }

public function delete($id) {
    $query = "UPDATE " . $this->table . " SET estado = 'baja' WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return ["message" => "Oferta dada de baja correctamente"];
    }
    return ["message" => "Error al dar de baja la oferta"];
}


}
