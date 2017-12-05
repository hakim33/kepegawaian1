<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employee;
use App\account;
use Illuminate\Support\Facades\Hash;

error_reporting(E_ALL & ~E_NOTICE);
session_start();
class index_controller extends Controller
{
    public function index(){
      if(isset($_SESSION["jabatan"])){
        if($_SESSION["jabatan"]=='manager'){
          return redirect('/admin');
        }else{
          return redirect("/pegawai");
        }
      }
      return view("index");
    }

    public function logout(){
      session_destroy();
      return redirect("/");
    }

    public function login(Request $r){
      $datas = account::where("username",strip_tags($r->username))->get();
      if(count($datas)>0){
        foreach ($datas as $data);
        if($data->username == strip_tags($r->username) && 
           Hash::check(strip_tags($r->password),$data->password)){
          $datas = employee::select("employees.nip","nama","jabatan")
                  ->join("accounts","accounts.nip","=","employees.nip")
                  ->where("username",strip_tags($r->username))->get();
          if(count($datas)>0){
            foreach ($datas as $data);
            $_SESSION["username"] = $r->username;
            $_SESSION["nip"] = $data->nip;
            $_SESSION["nama"] = $data->nama;
            $_SESSION["jabatan"] = strtolower($data->jabatan);
            if($_SESSION["jabatan"]=="manager"){
              echo "<script>window.location.href='admin'</script>";
            }else{
              echo "<script>window.location.href='pegawai'</script>";
            }
          }
        }else{
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Username atau password salah');
        }
      }else{
        session()->flash('title','Gagal');
        session()->flash('type','error');
        session()->flash('message','Username atau password salah');
      }
      return view("message");
    }
}
