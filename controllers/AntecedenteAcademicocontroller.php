<?php
// controllers/AntecedenteAcademicocontroller.php
require_once __DIR__ . '/../models/antecedenteacademico.php';
require_once __DIR__ . '/../config/db.php';

header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();
$academico = new AntecedenteAcademico($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($method) {
    case 'GET':
        if (isset($request[2]) && is_numeric($request[2])) {
            echo json_encode($academico->getById($request[2]));
        } else {
            echo json_encode($academico->getAll());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['candidato_id'], $data['institucion'], $data['titulo_obtenido'], $data['anio_ingreso'], $data['anio_egreso'])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos para registrar antecedente académico"]);
            break;
        }
        echo json_encode($academico->create($data));
        break;

    case 'PUT':
    case 'PATCH':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de antecedente académico no proporcionado"]);
            break;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode($academico->update($request[2], $data));
        break;

    case 'DELETE':
        if (!isset($request[2]) || !is_numeric($request[2])) {
            http_response_code(400);
            echo json_encode(["message" => "ID de antecedente académico no proporcionado"]);
            break;
        }
        echo json_encode($academico->delete($request[2]));
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido"]);
        break;
}