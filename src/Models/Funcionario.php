<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 01:41
 */

declare(strict_types=1);
namespace SONFin\Models;


use Illuminate\Database\Eloquent\Model;


class Funcionario extends Model implements FuncionarioInterface
{
    //Mass Assigment
    protected $fillable = [
      'first_name',
      'last_name',
      'endereco',
      'cpf',
      'function_id'
    ];

    public function categoryFunction()
    {
        //  1 para n
        return $this->belongsTo(CategoryFunction::class, 'function_id');
    }


    public function getId()
    {
        return (int)$this->id;
    }

    public function getFullname(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function getCpf(): int
    {
        return $this->cpf;
    }

    public function getFunctionId()
    {
        return (int)$this->categoryFunction()->id;
    }

}