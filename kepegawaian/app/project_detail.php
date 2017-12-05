<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project_detail extends Model
{
  //atribut
  public $timestamps = false;
  protected $fillable = ['nip','no','status'];

}
