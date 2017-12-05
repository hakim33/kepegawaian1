<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\account;
use App\absence;
use App\employee;
use App\project;
use App\project_detail;

error_reporting(E_ALL & ~E_NOTICE);
session_start();
date_default_timezone_set('Asia/Jakarta');

class pegawai_controller extends Controller
{
  public function __construct(){
      $this->middleware("employee:$_SESSION[jabatan]");
  }

  public function index(){
    if(file_exists("storage/app/public/foto/".
                   $_SESSION["nip"].'.jpeg')){
     $url = "storage/app/public/foto/".
                   $_SESSION["nip"].'.jpeg';
    }else{
      $url = asset("public/gambar/icon/unknown.png");
    }
    return view("employee.index",compact("url"));
  }

  public function download_berkas($file_name){
    $file = 'storage/app/public/berkas/'.$_SESSION["nip"]."/"."$file_name";
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
    $headers = ['Content-Type' => "$ctype",];
    return response()->download($file,$file_name,$headers);
  }

  public function edit_data(){
    if(file_exists("storage/app/public/foto/".
                    $_SESSION["nip"].'.jpeg')){
      $url = "storage/app/public/foto/".
              $_SESSION["nip"].'.jpeg';
      $stsfoto = 1;
    }else{
      $url = asset("public/gambar/icon/unknown.png");
      $stsfoto = 0;
    }
    $datas = employee::select("nip","nama","kelamin","jabatan","tgl_masuk",
             "telepon","alamat","gaji")->where("nip","$_SESSION[nip]")->get();
    return view("employee.operation.edit-data-employee",
                compact(["datas","url","stsfoto"]));
  }

  public function save_data(Request $r){
    DB::beginTransaction();
    try {
      employee::where("nip",$_SESSION["nip"])
                ->update(["telepon"=>strip_tags($r->telepon),
                "alamat"=>strip_tags($r->alamat)]);
      DB::commit();
      if($r->tempimg!=1){
        if($r->tempimg!=""){
          $data = $r->tempimg;
          list($type, $data) = explode(';', $data);
          list(, $data)      = explode(',', $data);
          $data = base64_decode($data);
          file_put_contents("storage/app/public/foto/".
                             $_SESSION["nip"].'.jpeg', $data);
          $f = finfo_open();
          $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
          list($width, $height) = getimagesizefromstring($data);
          $new_width = 300;
          $new_height = 350;
          $image_p = imagecreatetruecolor($new_width, $new_height);
          switch (strtolower($mime_type)) {
            case 'image/png':$image = imagecreatefrompng("storage/app/public/foto/".$_SESSION["nip"].'.jpeg');break;
            case 'image/jpg':$image = imagecreatefromjpeg("storage/app/public/foto/".$_SESSION["nip"].'.jpeg');break;
            case 'image/jpeg':$image = imagecreatefromjpeg("storage/app/public/foto/".$_SESSION["nip"].'.jpeg');break;
            case 'image/gif':$image = imagecreatefromgif("storage/app/public/foto/".$_SESSION["nip"].'.jpeg');break;
          }
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width,
                             $new_height, $width, $height);
          imagejpeg($image_p,"storage/app/public/foto/".
                    $_SESSION["nip"].'.jpeg',100);
        }else{
            unlink("storage/app/public/foto/".
                    $_SESSION["nip"].'.jpeg');
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
    return view("message");
  }

  public function show_data($sts){
    switch ($sts) {
      case 'show_absensi':
        $datas = absence::select("tanggal","status")
                 ->where([[DB::raw("MONTH(tanggal)"),DB::raw("MONTH(CURDATE())")],
                         ["nip",$_SESSION["nip"]]])
                 ->get();
        $years = absence::select(DB::raw("YEAR(tanggal) as tahun"))
                 ->where("nip",$_SESSION["nip"])
                 ->get();
        $tahun = date("Y");
        $bulan = date("m");
        return view("employee.operation.absence",
                     compact(["datas","tgl","years","tahun","bulan"]));
      break;
      case 'show_berkas':
        $path = "storage/app/public/berkas/$_SESSION[nip]";
        if(is_dir($path)){
          $arr = scandir($path,1);
          if(count($arr)==2){
            rmdir("storage/app/public/berkas/$_SESSION[nip]");
            return view("employee.operation.show-berkas");
          }else{
            return view("employee.operation.show-berkas",compact("arr"));
          }
        }else {
          return view("employee.operation.show-berkas");
        }
      break;
      case 'make_proyek':
        return view("employee.operation.make-proyek");
      break;
      case 'show_proyek':
        $datas = project::select("project_details.no","nama_proyek","tgl_mulai","tgl_selesai")
                ->join("project_details","project_details.no","=","projects.no")
                ->where([["projects.status",0],["nip",$_SESSION["nip"]]])->get();
        return view("employee.operation.show-proyek",compact("datas"));
      break;
    }
  }

  public function done_project($no){
    DB::beginTransaction();
    try {
      project::where("no",strip_tags($no))->update(["status"=>1]);
      DB::commit();
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message','Project selesai telah disimpan');
    } catch (Exception $e) {
      DB::rollback();
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Project tidak dapat disimpan');
    }
    return $this->show_data('show_proyek');
  }

  public function update_project(Request $r,$sts,$no){
    switch ($sts) {
      case '0':
        DB::beginTransaction();
        try {
          project::where("no",strip_tags($no))->update(["nama_proyek"=>strip_tags($r->nama0),
                    "tgl_mulai"=>strip_tags($r->tgl_mulai0),
                    "tgl_selesai"=>strip_tags($r->tgl_selesai0)]);
          project_detail::where("no",strip_tags($no))->delete();
          DB::commit();
          project_detail::insert(["nip"=>$_SESSION["nip"],"no"=>$no,"status"=>2]);
          $i = 1;
          $error = "";
          while (strip_tags($r["nip$i"])) {
            $ceks = employee::select("nip")->where("nip",strip_tags($r["nip$i"]))->get();
            if((count($ceks)>0)&&($r["nip$i"]!=$_SESSION["nip"])){
              project_detail::insert(["nip"=>strip_tags($r["nip$i"]),"no"=>$no]);
            }else if($r["nip$i"]!=$_SESSION["nip"]){
              $error = $error.strip_tags($r["nip$i"]).", ";
            }
            $i++;
          }
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          if($error==""){
            session()->flash('message','Proyek berhasil disimpan');
          }else{
            session()->flash('message','Proyek berhasil disimpan namun nip '.
                             $error.' tidak terdaftar pada data pegawai');
          }
        } catch (Exception $e) {
          DB::rollback();
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Proyek gagal disimpan');
        }
      break;
      case '1':
        DB::beginTransaction();
        try {
          project::where("no",strip_tags($no))
                    ->update(["nama_proyek"=>strip_tags($r->nama),
                    "tgl_mulai"=>strip_tags($r->tgl_mulai),
                    "tgl_selesai"=>strip_tags($r->tgl_selesai)]);
          DB::commit();
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          session()->flash('message','Proyek berhasil disimpan');
        } catch (Exception $e) {
          DB::rollback();
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Proyek gagal disimpan');
        }
      break;
    }
    return $this->show_data("show_proyek");
  }

  public function show_project($no){
    $datas = project::select("no","nama_proyek","tgl_mulai","tgl_selesai")
            ->where("no",$no)->get();
    $employees = project_detail::select("nama","project_details.status")
          ->join("employees","employees.nip","=","project_details.nip")
          ->where("no",$no)->get();
    return view("employee.operation.detail-proyek",compact(["datas","employees"]));
  }

  public function edit_project($no){
    $datas = project::select("no","nama_proyek","tgl_mulai","tgl_selesai")
            ->where("no",$no)->get();
    $employees = project_detail::select("nip")
                ->where([["no",$no],["status",1]])
                ->get();
    return view("employee.operation.edit-project",compact(["datas","employees"]));
  }

  public function delete_project($no){
    DB::beginTransaction();
    try {
      project::where("no",strip_tags($no))->delete();
      DB::commit();
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message','Project berhasil dihapus');
    } catch (Exception $e) {
      DB::rollback();
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Project gagal dihapus');
    }
    return $this->show_data('show_proyek');
  }

  public function save_project(Request $r,$sts){
    switch ($sts) {
      case '0':
        DB::beginTransaction();
        try {
          $nomors = project::select("no")->orderBy("no","desc")->limit(1)->get();
          if(count($nomors)>0){
            foreach ($nomors as $nomor);
            $no = $nomor->no + 1;
          }else{
            $no = 1;
          }
          project::insert(["no"=>$no,"nama_proyek"=>strip_tags($r->nama0),
                    "tgl_mulai"=>strip_tags($r->tgl_mulai0),
                    "tgl_selesai"=>strip_tags($r->tgl_selesai0)]);
          project_detail::insert(["nip"=>$_SESSION["nip"],"no"=>$no,"status"=>2]);
          $i = 1;
          $error = "";
          while (strip_tags($r["nip$i"])) {
            $ceks = employee::select("nip")->where("nip",strip_tags($r["nip$i"]))->get();
            if((count($ceks)>0)&&($r["nip$i"]!=$_SESSION["nip"])){
              project_detail::insert(["nip"=>strip_tags($r["nip$i"]),"no"=>$no]);
            }else if($r["nip$i"]!=$_SESSION["nip"]){
              $error = $error.strip_tags($r["nip$i"]).", ";
            }
            $i++;
          }
          DB::commit();
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          if($error==""){
            session()->flash('message','Proyek berhasil disimpan');
          }else{
            session()->flash('message','Proyek berhasil disimpan namun nip '.
                              $error.' tidak terdaftar pada data pegawai');
          }
        } catch (Exception $e) {
          DB::rollback();
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Proyek gagal disimpan');
        }
      break;
      case '1':
        DB::beginTransaction();
        try {
          $nomors = project::select("no")->orderBy("no","desc")->limit(1)->get();
          if(count($nomors)>0){
            foreach ($nomors as $nomor);
            $no = $nomor->no + 1;
          }else{
            $no = 1;
          }
          project::insert(["no"=>$no,"nama_proyek"=>strip_tags($r->nama),
                    "tgl_mulai"=>strip_tags($r->tgl_mulai),
                    "tgl_selesai"=>strip_tags($r->tgl_selesai)]);
          project_detail::insert(["nip"=>$_SESSION["nip"],"no"=>$no,"status"=>2]);
          DB::commit();
          session()->flash('title','Berhasil');
          session()->flash('type','success');
          session()->flash('message','Proyek berhasil disimpan');
        } catch (Exception $e) {
          DB::rollback();
          session()->flash('title','Gagal');
          session()->flash('type','error');
          session()->flash('message','Proyek gagal disimpan');
        }
      break;
    }
    return view("employee.operation.make-proyek");
  }

  public function upload_berkas(Request $r){
    if($r->cariberkas!=""){
      $document = $r->file("cariberkas");
      $name = $document->getClientOriginalName();
      if(!is_dir("storage/app/public/berkas/$_SESSION[nip]")){
       mkdir("../storage/app/public/berkas/$_SESSION[nip]",0777);
      }
      file_put_contents("storage/app/public/berkas/$_SESSION[nip]/".$name, file_get_contents($r->cariberkas));
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message','File berhasil di upload');
    }else{
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message','Limit upload dan post belum diatur pada server.
                        \\nPada local server silakan lakukan penyetingan sesuai
                        web server yang digunakan');
    }
    return $this->show_data('show_berkas');
  }

  public function delete_berkas($filename){
    if(Storage::delete("public/berkas/$_SESSION[nip]/".$filename)){
      session()->flash('title','Berhasil');
      session()->flash('type','success');
      session()->flash('message',$filename.' berhasil dihapus');
    }else{
      session()->flash('title','Gagal');
      session()->flash('type','error');
      session()->flash('message',$filename.' gagal dihapus');
    }
    return $this->show_data('show_berkas');
  }

  public function set_tanggal($bulan,$tahun){
    $bulan = strip_tags($bulan);
    $tahun = strip_tags($tahun);
    $datas = absence::select("tanggal","status")
             ->where([[DB::raw("MONTH(tanggal)"),"$bulan"],
               [DB::raw("YEAR(tanggal)"),"$tahun"],["nip",$_SESSION["nip"]]])
             ->get();
    return view("employee.operation.set-tanggal",compact("datas"));
  }
}
