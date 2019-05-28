<?php
require 'vendor/autoload.php';

use fileUploader\Adapter;
use fileUploader\ApiController;

define('UPLOAD_PATH', __DIR__ . '/assets/upload');

$router = new AltoRouter();
$api = new ApiController(Adapter::getInstance());

$router->map( 'GET', '/', function() use ($api) { });
$router->map( 'GET', '/getlist', function() use ($api) { $api->getListAction(); });
$router->map( 'GET', '/getusage', function() use ($api) { $api->getUsageAction(); });
$router->map( 'GET|POST', '/download/[i:id]', function( $id ) use ($api) { $api->getDownloadAction( $id ); });

$router->map( 'GET|POST', '/storefile', function() use ($api) { $api->storeFileAction(); });
$router->map( 'GET|POST', '/delete/[i:id]', function( $id ) use ($api) { $api->deleteAction( $id ); });

$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
