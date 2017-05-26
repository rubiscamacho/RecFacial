<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 16:28
 */

declare(strict_types=1);
namespace SONFin\Repository;


class RepositoryFactory
{
    public static function factory(string $modelClass)
    {
        return new DefaultRepository($modelClass);
    }
}