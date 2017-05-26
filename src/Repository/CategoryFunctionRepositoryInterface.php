<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 16:03
 */
declare(strict_types=1);
namespace SONFin\Repository;


interface CategoryFunctionRepositoryInterface extends RepositoryInterface
{
    public function sumByPeriod(string $dateStart, string $dateEnd, int $userId): array ;


}