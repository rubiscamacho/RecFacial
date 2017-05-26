<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 18/04/17
 * Time: 01:41
 */

namespace SONFin\Models;


use Illuminate\Database\Eloquent\Model;

class BillReceive extends Model
{
    //Mass Assigment
    protected $fillable = [
      'date_launch',
      'name',
      'value',
      'user_id'
    ];
}