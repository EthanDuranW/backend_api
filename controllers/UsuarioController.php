<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/db.php';
header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($method) {
    case 'GET':
        if (isset($request[2]) && is_numeric($request[2])) {
            echo json_encode($usuario->getById($request[2]));
        } else {
            echo json_encode($usuario->getAll());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (
            !$data ||
            !isset($data['nombre'], $data['apellido'], $data['email'], $data['clave'],
                     $data['fecha_nacimiento'], $data['telefono'], $data['direccion'], $data['rol'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para registro"]);
            break;
        }
        echo json_encode($usuario->create($data));
        break;


    case 'PATCH':
    case 'PUT':
        if (isset($request[2])) {
            $data = json_decode(file_get_contents("php://input"), true);
            if (
                !$data ||
                !isset($data['nombre'], $data['apellido'], $data['email'], $data['telefono'], $data['direccion'])
            ) {
                http_response_code(400);
                echo json_encode(["message" => "Datos incompletos para actualizar"]);
                break;
            }
            echo json_encode($usuario->update($request[2], $data));
        } else {
            http_response_code(400);
            echo json_encode(["message" => "ID no proporcionado"]);
        }
        break;

    case 'DELETE':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de reclutador no proporcionado"]);
            break;
        }
        echo json_encode($usuario->delete($request[2]));
        break;


    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido"]);
}
?>
