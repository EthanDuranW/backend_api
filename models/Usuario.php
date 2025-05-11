<?php
// models/Usuario.php
class Usuario {
    private $conn;
    private $tabla = "Usuario";

    public function __construct($db) {
        $this->conn = $db;
    }

public function getAll() {
    $query = "SELECT * FROM " . $this->tabla . " WHERE estado = 'activo'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getById($id) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByRole($rol) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE rol = :rol";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByRoleAndId($rol, $id) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id = :id AND rol = :rol";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->tabla . " 
            (nombre, apellido, email, clave, fecha_nacimiento, telefono, direccion, rol)
            VALUES 
            (:nombre, :apellido, :email, :clave, :fecha_nacimiento, :telefono, :direccion, :rol)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':clave', $data['clave']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':rol', $data['rol']);

        if ($stmt->execute()) {
            return ["message" => "Usuario registrado con éxito"];
        }
        return ["message" => "Error al registrar usuario"];
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->tabla . " 
                  SET nombre = :nombre, apellido = :apellido, email = :email,
                      clave = :clave, fecha_nacimiento = :fecha_nacimiento,
                      telefono = :telefono, direccion = :direccion, rol = :rol
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':clave', $data['clave']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':rol', $data['rol']);

        if ($stmt->execute()) {
            return ["message" => "Usuario actualizado con éxito"];
        }
        return ["message" => "Error al actualizar usuario"];
    }

public function delete($id) {
    $query = "UPDATE " . $this->tabla . " SET estado = 'inactivo' WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return ["message" => "Usuario desactivado correctamente"];
    }
    return ["message" => "Error al desactivar usuario"];
}

}
