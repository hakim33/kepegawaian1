<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
  protected $fillable = ['nip','nama','kelamin','jabatan','gaji','telepon','alamat','status'];
  public $timestamps = false;
}
