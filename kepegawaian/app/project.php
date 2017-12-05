<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
  //atribut
  public $timestamps = false;
  protected $fillable = ['no','nama_proyek','tgl_mulai',
          'tgl_selesai','status'];

}
