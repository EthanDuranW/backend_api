<?php
require_once __DIR__ . '/../models/usuario.php';
require_once __DIR__ . '/../config/db.php';

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($method) {
    case 'GET':
        if (isset($request[2]) && is_numeric($request[2])) {
            echo json_encode($usuario->getByRoleAndId('Reclutador', $request[2]));
        } else {
            echo json_encode($usuario->getAllByRole('Reclutador'));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['nombre'], $data['apellido'], $data['email'], $data['clave'], $data['fecha_nacimiento'], $data['telefono'], $data['direccion'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para crear reclutador"]);
            break;
        }
        $data['rol'] = 'Reclutador';
        echo json_encode($usuario->create($data));
        break;

    case 'PUT':
    case 'PATCH':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de reclutador no proporcionado"]);
            break;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($usuario->update($request[2], $data));
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
        break;
}
