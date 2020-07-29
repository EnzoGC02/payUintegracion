<?php


$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/pagos/tarjetacredito','PayUGatewayController@tarjetaDeCredito');
$router->get('/pagos/efectivo','PayUGatewayController@efectivo');
$router->get('/pagos/ordershow','PayUGatewayController@getOrden');
$router->get('/pagos/methodsshow','PayUGatewayController@metodosDePago');
