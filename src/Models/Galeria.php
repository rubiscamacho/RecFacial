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


class Galeria extends Model implements GaleriaInterface
{
    //Mass Assigment
    protected $fillable = [
      'name',
      'funcionario_id'
    ];

    public function categoryFuncionario()
    {
        //  1 para n
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }


    public function getId()
    {
        return (int)$this->id;
    }

    public function getImagem(): string
    {
        return $this->name;
    }
}