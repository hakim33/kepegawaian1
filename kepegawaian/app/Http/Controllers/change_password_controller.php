<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\account;
use App\absence;
error_reporting(E_ALL & ~E_NOTICE);
session_start();
date_default_timezone_set('Asia/Jakarta');
class change_password_controller extends Controller
{
  public function index(){
    return view("template.change-password");
  }

  public function save_new_password(Request $r){
    $pass = strip_tags($r->newpassword);
    $lastpass = strip_tags($r->lastpassword);
    $ceks = account::where("username","$_SESSION[username]")->get();
    if(count($ceks)>0){
      DB::beginTransaction();
      try {
        foreach ($ceks as $cek);
        if(($cek->username == $_SESSION["username"]) && 
           (Hash::check("$lastpass","$cek->password"))){
          $pass = Hash::make("$pass");
          account::where("username",$_SESSION["username"])
          ->update(["password"=>"$pass"]);
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          session()->flash('message','Password berhasil diubah');
        }else{
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Password lama anda salah');
        }
        DB::commit();
      } catch (Exception $e) {
        DB::rollback();
      }
    }
    return view("message");
  }
}
