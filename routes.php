<?php

function call($action, $controller) {

    $objController = new $controller;
    global $authorized;
    if ($authorized) {
        $objController->{$action}()->afficher();
    } else {
        http_response_code(401);
        echo "<h1>401: Not Authorized</h1>";
    }
}

$controllers = glob("Controllers/*.php");
foreach ($controllers as &$controllerTempo){
    $controllerTempo = substr(substr($controllerTempo, 0, -4),12);
}
unset($controllerTempo);

$controller .= 'Controller';
if (in_array($controller, $controllers)) {
    require_once('Controllers/' . $controller .'.php');
    if (in_array($action, get_class_methods($controller))) {
        call($action, $controller);
    } else {
        require_once('Controllers/autresController.php');
        call('erreur', 'autresController');
    }
} else {
    require_once('Controllers/autresController.php');
    call( 'erreur', 'autresController');
}