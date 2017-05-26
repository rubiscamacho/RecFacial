<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 16:03
 */
declare(strict_types=1);
namespace SONFin\Repository;


interface RepositoryInterface
{
    public function all(): array ;

    public function find(int $id);


    public function create(array $data);

    public function update( $id, array $data);

    public function delete( $id);

    public function findByField(string $field, $value) ;

    public function findOneBy(array $search);

}