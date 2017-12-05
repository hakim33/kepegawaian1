<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absence extends Model
{
  protected $fillable = ['no','tanggal','nip','status'];
  public $timestamps = false;
}
