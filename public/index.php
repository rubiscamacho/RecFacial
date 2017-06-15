<?php
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}
use Psr\Http\Message\ServerRequestInterface;
use SONFin\Application;
use SONFin\Plugins\AuthPlugin;
use SONFin\Plugins\DbPlugin;
use SONFin\Plugins\RoutePlugin;
use SONFin\Plugins\ViewPlugin;
use SONFin\ServiceContainer;


require __DIR__ . '/../vendor/autoload.php';

if(file_exists(__DIR__ . '/../.env')){
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->overload();
}


require_once  __DIR__ . '/../src/helpers.php';

    $serviceContainer = new ServiceContainer();
    $app = new Application($serviceContainer);

    $app->plugin(new RoutePlugin());
    $app->plugin(new ViewPlugin());
    $app->plugin(new DbPlugin());
    $app->plugin(new AuthPlugin());

    $app->get('/home/{name}/{id}', function (ServerRequestInterface $request){
        $response = new \Zend\Diactoros\Response();
        $response->getBody()->write("response com emiter do diactoros");

        return $response;
    });


require_once __DIR__ . '/../src/controllers/category-functions.php';
require_once __DIR__ . '/../src/controllers/galeria.php';
require_once __DIR__ . '/../src/controllers/funcionario.php';
require_once __DIR__ . '/../src/controllers/album.php';
require_once __DIR__ . '/../src/controllers/users.php';
require_once __DIR__ . '/../src/controllers/auth.php';


$app->start();
