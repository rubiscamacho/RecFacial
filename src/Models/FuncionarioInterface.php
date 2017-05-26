<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 20/04/17
 * Time: 16:55
 */

declare(strict_types=1);
namespace SONFin\Models;


interface FuncionarioInterface
{
    public function getId();

    public function getFullname():string;

    public function getEndereco():string ;

    public function getCpf():int;

}