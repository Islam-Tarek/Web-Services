<?php

require("./vendor/autoload.php");

$request = new RequestHandler();
$method = $request->getMethod();

$url = $_SERVER['REQUEST_URI'];
$urlPieces = explode("/", $url);
header("Content-Type: application/json");




$result = [];


$itemService = new ItemServices();

switch ($method) {
    case 'GET':
        if ($request->getResourceId()) {
            $result = $itemService->getItem($request->getResourceId());
        } else {
            $result = $itemService->getAllItems();
        }
        break;

    case 'POST':
        // "php://input  ==> all the datat that sent in the request body"
        $id = $request->getResourceId();
        if ($id) {
            http_response_code(405);
            echo json_encode([
                'error' => "wrong URL"
            ]);
            exit;
        } else {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $itemService->createItem($data);
        }
        break;

    case 'PUT':
        $id = $request->getResourceId();
        if (!$id) {
            http_response_code(405);
            echo json_encode([
                'error' => "you should send the item ID"
            ]);
            exit;
        } else {

            $data = json_decode(file_get_contents("php://input"), true);
            $result = $itemService->updateItem($id, $data);
        }

        break;

    case 'DELETE':
        $id = $request->getResourceId();

        if (!$id) {
            http_response_code(405);
            echo json_encode([
                'error' => "you should send the item ID"
            ]);
            exit;
        }

        $result = $itemService->deleteItem($id);

        break;

    default:
        // return error methodnot allowed
        header("Content-Type: application/json");
        http_response_code(405);
        echo json_encode([
            'error' => 'Operation not allowed'
        ]);
        exit;
        break;
}

echo response($result);

function response($data)
{
    header("Content-Type: application/json");

    if (is_bool($data)) {
        return $data ?
            successResponse(['message' => 'completed successfully'], 200)
            : errorResponse(['message' => 'something went wrong'], 500);
    }
    if (is_array($data)) {
        return !empty($data) ?
            successResponse($data, 200)
            : errorResponse(['message' => 'item not found'], 404);
    }
}

function successResponse($data, $code)
{
    http_response_code($code);
    return json_encode([
        'success' => $data
    ]);
}

function errorResponse($data, $code)
{
    http_response_code($code);
    return json_encode([
        'error' => $data
    ]);
}
