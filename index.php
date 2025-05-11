<?php
header("Content-Type: application/json");

// Obtener la ruta real ignorando todo antes de 'index.php'
$request_uri = str_replace("/index.php", "", $_SERVER['REQUEST_URI']);
$request = explode('/', trim($request_uri, '/'));

// La entidad estará en $request[0] (ej. "postulaciones")
// El ID (si existe) estará en $request[1]
$entity = $request[0] ?? '';
$id = $request[1] ?? null;

switch ($entity) {
    case 'usuarios':
        require 'controllers/UsuarioController.php';
        break;
    case 'ofertas':
        require 'controllers/ofertacontroller.php';
        break;
    case 'postulaciones':
        require 'controllers/postulacioncontroller.php';
        break;
    case 'antecedentes_academicos':
        require 'controllers/AntecedenteAcademicocontroller.php';
        break;
    case 'antecedentes_laborales':
        require 'controllers/AntecedenteLaboralcontroller.php';
        break;
    case 'candidatos':
        require 'controllers/CandidatoController.php';
        break;
    case 'reclutadores':
        require 'controllers/ReclutadorController.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Ruta no encontrada"]);
        break;
}

