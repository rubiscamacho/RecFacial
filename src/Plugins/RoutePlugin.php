<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 17/04/17
 * Time: 15:49
 */

declare(strict_types=1);

namespace SONFin\Plugins;


use Aura\Router\RouterContainer;
use Psr\Http\Message\RequestInterface;
use SONFin\ServiceContainerInterface;

class RoutePlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $routerContainer = new RouterContainer();
        /* Registra rota da aplicacao */
        $map = $routerContainer->getMap();
        /* Indentifica a rota que esta sendo acessada */
        $matcher = $routerContainer->getMatcher();
        /* Gera links com base nas rotas registradas*/
        $generator = $routerContainer->getGenerator();

        $request = $this->getRequest();

        $container->add('routing', $map);
        $container->add('routing.matcher', $matcher);
        $container->add('routing.generator', $generator);
        $container->add(RequestInterface::class,  $request);

        $container->addLazy(
            'route', function (\Interop\Container\ContainerInterface $container) {
                $matcher = $container->get('routing.matcher');
                $request = $container->get(RequestInterface::class);
                return $matcher->match($request);
            }
        );
    }

    protected function getRequest():RequestInterface
    {
        return \Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }
}