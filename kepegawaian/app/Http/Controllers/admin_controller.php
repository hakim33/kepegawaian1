<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\employee;
use App\account;
use App\absence;
use App\project;
use App\project_detail;
use DateTime;

error_reporting(E_ALL & ~E_NOTICE);
session_start();
date_default_timezone_set('Asia/Jakarta');
class admin_controller extends Controller
{
  public function __construct(){
      $this->middleware("admin:$_SESSION[jabatan]");
  }

  public function index(){
    if(file_exists("storage/app/public/foto/".$_SESSION["nip"].'.jpeg')){
     $url = "storage/app/public/foto/".$_SESSION["nip"].'.jpeg';
    }else{
      $url = asset("public/gambar/icon/unknown.png");
    }
    return view("admin.index",compact("url"));
  }

  public function search_employee($val,$sts){
    if($val!="default"){
      $datas = employee::select("nip","nama","kelamin","jabatan","gaji")
               ->whereRaw("status = $sts and lower(nama) like lower('%$val%') or
                           nip like '%$val%' or jabatan like '%$val%' or gaji = '$val'")
                ->orderBy("nama","asc")->limit(5)->get();
      $counts = employee::select(DB::raw("count(*) as jum"))
                ->whereRaw("status = $sts and lower(nama) like lower('%$val%') or
                           nip like '%$val%' or jabatan like '%$val%' or gaji = '$val'")->get();
    }else{
      $datas = employee::select("nip","nama","kelamin","jabatan","gaji")
              ->where("status",$sts)->orderBy("nama","asc")->limit(5)->get();
      $counts = employee::select(DB::raw("count(*) as jum"))->where("status",$sts)->get();
    }
    $pesan = "Tidak data data pegawai";
    return view("admin.operation.get-data-employees",compact(['datas','sts','pesan','counts']));
  }

  public function delete_berkas($filename,$nip,$sts){
    if(unlink("storage/app/public/berkas/$nip/$filename")){
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message',$filename.' berhasil dihapus');
    }else{
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message',$filename.' gagal dihapus');
    }
    return $this->show_berkas($nip,$sts);
  }

  public function show_berkas($nip,$sts){
    $nip = strip_tags($nip);
    $path = "storage/app/public/berkas/$nip";
    if(is_dir($path)){
      $arr = scandir($path,1);
      if(count($arr)==2){
        rmdir("storage/app/public/berkas/$nip");
        return view("admin.operation.show-berkas",compact(["sts","nip"]));
      }else{
        return view("admin.operation.show-berkas",compact(["arr","sts","nip"]));
      }
    }else {
      return view("admin.operation.show-berkas",compact(["sts","nip"]));
    }
  }

  public function detail_project($no){
    $datas = project::select("no","nama_proyek","tgl_mulai","tgl_selesai")
            ->where("no",$no)->get();
    $employees = project_detail::select("nama","project_details.status")
          ->join("employees","employees.nip","=","project_details.nip")
          ->where("no",$no)->get();
    return view("admin.operation.detail-proyek",compact(["datas","employees"]));
  }

  public function download_berkas($file_name,$nip){
    $file = 'storage/app/public/berkas/'.$nip."/".$file_name;
    $type = pathinfo($file, PATHINFO_EXTENSION);
    switch ($type) {
      case "pdf": $ctype="application/pdf"; break;
      case "txt": $ctype="text/plain"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "docx": $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";break;
      case "doc": $ctype="application/msword"; break;
      case "xlsx": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "pptx": $ctype = "application/vnd.openxmlformats-officedocument.presentationml.presentation";break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpg": $ctype="image/jpg"; break;
      case "tiff": $ctype="image/tiff"; break;
      case "psd": $ctype="image/psd"; break;
      case "bmp": $ctype="image/bmp"; break;
      case "ico": $ctype="image/vnd.microsoft.icon"; break;
      default: $ctype="application/force-download";
    }
    $headers = [
            'Content-Type' => "$ctype",
        ];
    return response()->download($file,$file_name,$headers);
  }

  public function detail_data($nip,$sts){
    switch ($sts) {
      case 0:
        $datas = employee::select("nip","nama","kelamin","jabatan","gaji","tgl_masuk","telepon","alamat")
        ->where("nip",strip_tags("$nip"))->get();
        $sts = 1;
      break;
      case 1:
        $datas = employee::select("nip","nama","kelamin","jabatan","gaji","tgl_masuk","telepon","alamat")
        ->where("nip",strip_tags("$nip"))->get();
        $sts = 2;
      break;
    }
    if (file_exists("storage/app/public/foto/".$nip.'.jpeg')) {
      $url = 'storage/app/public/foto/'.$nip.'.jpeg';
      if($data->kelamin == 'P'){
        $kelamin = "Pria";
      }else{
        $kelamin = "Wanita";
      }
    }else{
      $stsfoto = 0;
      if($data->kelamin == 'P'){
        $url = asset("public/gambar/icon/employee-notfound.png");
        $kelamin = "Pria";
      }else{
        $url = asset("public/gambar/icon/employee-notfound-w.png");
        $kelamin = "Wanita";
      }
    }
    return view("admin.operation.detail-data-employee",compact(["datas","sts","nip","url","kelamin"]));
  }

  public function save_data(Request $r){
    $ceknips = employee::select("nip")->where("nip",strip_tags($r->nip))->get();
    if((count($ceknips)<=0)||((count($ceknips)>=0)&&($r->nip==$r->tempnip))){
      DB::beginTransaction();
      try {
        employee::where("nip",strip_tags($r->tempnip))->update(["nip"=>strip_tags($r->nip),
                  "nama"=>strtolower(strip_tags($r->nama)),"kelamin"=>strip_tags($r->kelamin),
                  "tgl_masuk"=>strip_tags($r->tgl_masuk),"jabatan"=>strtolower(strip_tags($r->jabatan)),
                  "gaji"=>strip_tags($r->gaji),
                  "telepon"=>strip_tags($r->telepon),"alamat"=>strip_tags($r->alamat)]);
        DB::commit();
        echo "<script>document.getElementById('tempnip2').value= '$r->nip';</script>";
        if($r->tempimg!=1){
          if($r->tempimg!=""){
            $data = $r->tempimg;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            if($r->nip!=$r->tempnip){
              unlink("storage/app/public/foto/".$r->tempnip.'.jpeg');
            }
            file_put_contents("storage/app/public/foto/".$r->nip.'.jpeg', $data);
            $f = finfo_open();
            $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
            list($width, $height) = getimagesizefromstring($data);
            $new_width = 300;
            $new_height = 350;
            $image_p = imagecreatetruecolor($new_width, $new_height);
            switch (strtolower($mime_type)) {
              case 'image/png':$image = imagecreatefrompng("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/jpg':$image = imagecreatefromjpeg("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/jpeg':$image = imagecreatefromjpeg("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/gif':$image = imagecreatefromgif("storage/app/public/foto/".$r->nip.'.jpeg');break;
            }
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($image_p,"storage/app/public/foto/".$r->nip.'.jpeg',100);
          }else{
            unlink("storage/app/public/foto/".$r->tempnip.'.jpeg');
          }
        }else if($r->nip!=$r->tempnip){
          if (file_exists("storage/app/public/foto/".$r->tempnip.'.jpeg')) {
            rename('storage/app/public/foto/'.$r->tempnip.'.jpeg',
                   'storage/app/public/foto/'.$r->nip.'.jpeg');
          }
        }
        session()->flash('title','Berhasil');
        session()->flash('type','success');
        session()->flash('message','Data pegawai berhasil diubah');
      } catch (Exception $e) {
        DB::rollback();
        session()->flash('title','Gagal');
        session()->flash('type','error');
        session()->flash('message','Data pegawai gagal diubah');
      }
    }else{
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Nomor induk pegawai telah digunakan oleh pegawai lain');
    }
    return view("message");
  }

  public function save_absensi($nip,$sts,$date){
    $nip = strip_tags($nip);
    $sts = strip_tags("$sts");
    $date = strip_tags($date);
    DB::beginTransaction();
    try {
      absence::where([["nip","$nip"],[DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),"$date"]])
        ->update(["status"=>"$sts"]);
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  public function save_new_data(Request $r){
    DB::beginTransaction();
    try {
      $cekakuns = account::select("username")->where("username",strip_tags($r->username))->get();
      $ceknips = employee::select("nip")->where("nip",strip_tags($r->nip))->get();
      $pass = strip_tags($r->password);
      $pass = Hash::make($pass);
      $user = strip_tags($r->username);
      $gaji = strip_tags($r->gaji);
      if($gaji==""){
        $gaji=0;
      }
      if((count($cekakuns)<=0)&&(count($ceknips)<=0)){
        employee::insert(["nip"=>strip_tags("$r->nip"),"nama"=>strtolower(strip_tags($r->nama)),
            "kelamin"=>strip_tags($r->kelamin),"tgl_masuk"=>strip_tags($r->tgl_masuk),
            "jabatan"=>strtolower(strip_tags($r->jabatan)),
            "gaji"=>$gaji,"telepon"=>strip_tags($r->telepon),
            "alamat"=>strip_tags($r->alamat),"status"=>1]);
        account::insert(["nip"=>strip_tags("$r->nip"),"username"=>"$user","password"=>"$pass"]);
        DB::commit();
        if($r->tempimg!=1){
          if($r->tempimg!=""){
            $data = $r->tempimg;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents("storage/app/public/foto/".$r->nip.'.jpeg', $data);
            $f = finfo_open();
            $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
            list($width, $height) = getimagesizefromstring($data);
            $new_width = 300;
            $new_height = 350;
            $image_p = imagecreatetruecolor($new_width, $new_height);
            switch (strtolower($mime_type)) {
              case 'image/png':$image = imagecreatefrompng("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/jpg':$image = imagecreatefromjpeg("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/jpeg':$image = imagecreatefromjpeg("storage/app/public/foto/".$r->nip.'.jpeg');break;
              case 'image/gif':$image = imagecreatefromgif("storage/app/public/foto/".$r->nip.'.jpeg');break;
            }
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($image_p,"storage/app/public/foto/".$r->nip.'.jpeg',100);
          }
        }
        session()->flash('title','Berhasil');
        session()->flash('type','success');
        session()->flash('message','Data pegawai telah disimpan');
      }
    } catch (Exception $e) {
      DB::rollback();
    }
    return $this->show_data("show_data_pegawai");
  }

  public function search_username($val){
    $datas = account::select("username")->where("username","$val")->get();
    return view("admin.operation.validasi-username",compact("datas"));
  }

  public function search_nip($val){
    $datas = employee::select("nip")->where("nip","$val")->get();
    return view("admin.operation.validasi-nip",compact("datas"));
  }

  public function add_new_data(){
    $jobs = employee::select("jabatan")->groupBy("jabatan")->get();
    return view("admin.operation.new-data-employee",compact("jobs"));
  }

  public function edit_data($nip){
    $datas = employee::select("nip","nama","kelamin","jabatan","gaji","tgl_masuk","telepon","alamat")
            ->where("nip",strip_tags("$nip"))->get();
    $jobs = employee::select("jabatan")->groupBy("jabatan")->get();
    if (file_exists("storage/app/public/foto/".$nip.'.jpeg')) {
      $url = 'storage/app/public/foto/'.$nip.'.jpeg';
      $stsfoto = 1;
    }else{
      $stsfoto = 0;
      if($data->kelamin == 'P'){
        $url = asset("public/gambar/icon/employee-notfound.png");
      }else{
        $url = asset("public/gambar/icon/employee-notfound-w.png");
      }
    }
    return view("admin.operation.edit-data-employee",compact(["datas","jobs","url","stsfoto"]));
  }

  public function delete_data($nip,$sts){
    DB::beginTransaction();
    try {
      switch ($sts) {
        case 0 :
          employee::where("nip",strip_tags($nip))->update(["status"=>2]);
          DB::commit();
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          session()->flash('message','Data pegawai dipindahkan ke folder sampah');
          return $this->show_data("show_data_pegawai");
        break;
        case 1 :
          employee::where("nip",strip_tags($nip))->update(["status"=>0]);
          DB::commit();
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          session()->flash('message','Data pegawai telah dihapus');
          return $this->show_data("show_data_trash");
        break;
      }
    } catch (Exception $e) {
      DB::rollback();
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Data pegawai gagal dihapus');
    }
  }

  public function restore_data($nip){
    DB::beginTransaction();
    try {
      employee::where("nip",strip_tags($nip))->update(["status"=>1]);
      DB::commit();
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message','Data pegawai telah direstore');
    } catch (Exception $e) {
      DB::rollback();
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Data pegawai gagal direstore');
    }
    return $this->show_data("show_data_trash");
  }

  public function next_data_employees($no,$skip,$sts){
    $datas = employee::select("nip","nama","kelamin","jabatan","gaji")
            ->where("status",$sts)->orderBy("nama","asc")->skip($skip)->take(5)->get();
    return view("admin.operation.get-next-page",compact(['datas','sts']));
  }

  public function next_data_employees_with_page($no,$skip,$sts,$val){
    $datas = employee::select("nip","nama","kelamin","jabatan","gaji")->whereRaw("status = $sts
            and lower(nama) like lower('%$val%') or nip like '%$val%' or jabatan like '%$val%' or
            gaji = '$val'")->skip($skip)->take(5)->get();
    return view("admin.operation.get-next-page",compact(['datas','sts']));
  }

  public function next_absen($date){
    $date = strip_tags($date);
    $datas= employee::select("employees.nip","nama","jabatan","absences.status")
          ->leftJoin("absences","employees.nip","=","absences.nip")
          ->where([["employees.status",1],[DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),"$date"]])->get();
    return view("admin.operation.np-absen",compact("datas"));
  }

  public function delete_absence($date){
    $date = strip_tags($date);
    $ceks = absence::select("tanggal")->where(DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),"$date")->get();
    if(count($ceks)>0){
      try {
        absence::where(DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),"$date")->delete();
        DB::commit();
      } catch (Exception $e) {
        DB::rollback();
      }
    }
    return $this->next_absen($date);
  }

  public function make_absence($date){
    $date = strip_tags($date);
    $ceks = absence::select("tanggal")->where(DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),"$date")->get();
    if(count($ceks)<=0){
      $datas = employee::select("nip")->where("status",1)->get();
      if(count($datas)>0){
        DB::beginTransaction();
        try {
          foreach ($datas as $data) {
            absence::insert(["tanggal"=>"$date","nip"=>$data->nip]);
          }
          DB::commit();
        } catch (Exception $e) {
          DB::rollback();
        }
      }
    }
    return $this->next_absen($date);
  }

  public function show_data($sts){
    switch ($sts) {
      case 'show_data_pegawai':
        $datas = employee::select("nip","nama","kelamin","jabatan","gaji")
                ->where("status",1)->orderBy("nama","asc")->limit(5)->get();
        $counts = employee::select(DB::raw("count(*) as jum"))->where("status",1)->get();
        $sts = 1;
        $pesan = "Tidak data data pegawai";
        return view("admin.operation.show-data-employees",compact(['datas','sts','pesan','counts']));
      break;
      case 'show_data_trash':
        $datas = employee::select("nip","nama","kelamin","jabatan","gaji")
                ->where("status",2)->orderBy("nama","asc")->limit(5)->get();
        $counts = employee::select(DB::raw("count(*) as jum"))->where("status",2)->limit(10)->get();
        $sts = 2;
        $pesan = "Tidak ada data sampah pegawai";
        return view("admin.operation.show-data-employees",compact(['datas','sts','pesan','counts']));
      break;
      case 'show_absensi':
        $datas= employee::select("employees.nip","nama","jabatan","absences.status")
              ->leftJoin("absences","employees.nip","=","absences.nip")
              ->where([["employees.status",1],[DB::raw("Date_Format(tanggal,'%Y-%m-%d')"),DB::raw("CURDATE()")]])->get();
        $tgl = date("Y-m-d");
        return view("admin.operation.absence",compact(["datas","tgl"]));
      break;
      case 'show_project':
        $datas = project::select("project_details.no","nama_proyek","tgl_mulai","tgl_selesai")
                ->join("project_details","project_details.no","=","projects.no")
                ->where("projects.status",0)->get();
        return view("admin.operation.show-proyek",compact("datas"));
      break;
    }
  }
}
