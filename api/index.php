<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require './routes.php';
require './models/model.php';
// defino o método http e a url amigável
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';
// instancio o Router
$router = new Router($method, $path);

// registro as rotas
$router->get('/', function () {
    return array('result' => false);
});

$router->post('/{interface}/{action}', function ($params) {
    if($params[1] == 'product'){
        $product = new Product();
        if($params[2] == 'create'){
            $result = $product->create($_POST['name'], $_POST['price'], $_POST['amount'], $_POST['sku'], $_POST['description'], $_POST['category'], $_POST['url']);
            return array('result' => $result);
        } else if($params[2] == 'read'){
            $result = isset($_POST['id']) ? $product->read($_POST['id']) : $product->read();
            return array('result' => $result);
        } else if($params[2] == 'update'){
            $result = $product->update($_POST['id'], $_POST['name'], $_POST['price'], $_POST['amount'], $_POST['sku'], $_POST['description'], $_POST['category'], $_POST['url']);
            return array('result' => $result);
        } else if($params[2] == 'delete'){
            $result = $product->delete($_POST['id']);
            return array('result' => $result);
        }
    } else if($params[1] == 'category'){
        $category = new Category();
        if($params[2] == 'create'){
            $result = $category->create($_POST['name'], $_POST['code']);
            return array('result' => $result);
        } else if($params[2] == 'read'){
            $result = isset($_POST['id']) ? $category->read($_POST['id']) : $category->read();
            return array('result' => $result);
        } else if($params[2] == 'update'){
            $result = $category->update($_POST['id'], $_POST['name'], $_POST['code']);
            return array('result' => $result);
        } else if($params[2] == 'delete'){
            $result = $category->delete($_POST['id']);
            return array('result' => $result);
        }
    } else {
        return array('result' => false);
    }
});

// faço o router encontrar a rota que o usuário acessou
$result = $router->handler();
// se retornar false, dou um erro 404 de página não encontrada
if (!$result) {
    http_response_code(404);
    return array('result' => false);
    die();
}

// imprimo a página atual
echo json_encode($result($router->getParams()));