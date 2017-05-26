<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 01:41
 */

namespace SONFin\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryCost extends Model
{
    //Mass Assigment
    protected $fillable = [
      'name',
      'user_id'
    ];
}