<?php
// controllers/ofertacontroller.php
require_once __DIR__ . '/../models/oferta.php';
require_once __DIR__ . '/../config/db.php';

header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();
$oferta = new Oferta($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($method) {
    case 'GET':
        if (isset($request[2]) && is_numeric($request[2])) {
            echo json_encode($oferta->getById($request[2]));
        } else {
            echo json_encode($oferta->getAll());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (
            !$data || 
            !isset($data['titulo'], $data['descripcion'], $data['ubicacion'], $data['salario'], 
                    $data['tipo_contrato'], $data['fecha_cierre'], $data['reclutador_id'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para registrar oferta"]);
            break;
        }
        echo json_encode($oferta->create($data));
        break;

    case 'PUT':
    case 'PATCH':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de oferta no proporcionado"]);
            break;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($oferta->update($request[2], $data));
        break;

    case 'DELETE':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de oferta no proporcionado"]);
            break;
        }
        echo json_encode($oferta->delete($request[2]));
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido"]);
        break;
}
