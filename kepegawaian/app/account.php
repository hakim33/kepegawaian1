<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account extends Model
{
  protected $fillable = ['nip','username','password'];
  public $timestamps = false;
}
