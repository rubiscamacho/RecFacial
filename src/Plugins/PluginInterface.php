<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 17/04/17
 * Time: 12:38
 */

namespace SONFin\Plugins;


use SONFin\ServiceContainerInterface;

interface PluginInterface
{
    public function register(ServiceContainerInterface $container);
}