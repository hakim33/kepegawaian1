@extends('template.index')

@section('lib')
  <script type="text/javascript" src="{!! asset('public/js/admin.js') !!}"></script>
  <link rel="stylesheet" href="{!!asset('public/css/croppie.css')!!}" />
  <link rel="stylesheet" href="{!!asset('pubic/css/admin.css')!!}" />
  <script src="{!!asset('public/js/croppie.js')!!}"></script>
  <script src="{!!asset('public/js/jquery-ui.js')!!}"></script>
  <link rel="stylesheet" href="{!!asset('public/css/jquery-ui.css')!!}" />
@endsection

@section('content')
  @include('admin.operation.dashboard')
@endsection

@section('login')
  <div id="userlogin" onclick="show_optionlogin();">
    @php
      if($url != asset("public/gambar/icon/unknown.png")){
        $type = pathinfo($url, PATHINFO_EXTENSION);
        $data = file_get_contents($url);
        $url = 'data:image/'.$type.';base64,'.base64_encode($data);
      }
    @endphp
    <img src="{{$url}}">
    <span>{{$_SESSION["nama"]}}</span>
  </div>
  <div id="optionlogin" class="hide">
    <ul>
      <li class="animasi" onclick="change_password()">Ubah Password</li>
      <hr>
      <li class="animasi" onclick="logout()">Logout</li>
    </ul>
  </div>
  <script type="text/javascript">
    $(window).click(function() {
      $("#optionlogin").addClass("hide");
    });

    $('#optionlogin').click(function(event){
        event.stopPropagation();
    });

    $('#userlogin').click(function(event){
        event.stopPropagation();
    });
  </script>
@endsection

@section('sidebar')
  <ul>
    {{-- menu1 --}}
    <li id="parent1" class="first-child employee icon" onclick="show_nav_menu('parent1','second_menu1')">
      <div class="animasi"></div>
      <a href="#">
        <span>Olah Data Pegawai</span>
      </a>
    </li>
    <li>
      <ul id="second_menu1">
        <li class="eye icon" onclick="show_data('show_data_pegawai')">Lihat Data Pegawai</li>
        <li class="add icon" onclick="add_new_data()">Tambah Data Pegawai</li>
        <li class="trashmenu icon" onclick="show_data('show_data_trash')">Sampah Data Pegawai</li>
      </ul>
    </li>
    {{-- menu2 --}}
    <li id="parent2" onclick="show_data('show_absensi')" class="first-child list icon">
      <a href="#">
        <span>Absensi</span>
      </a>
    </li>
    {{-- menu3 --}}
    <li onclick="show_data('show_project')" class="first-child blacktask icon">
      <a href="#">
        <span>Proyek Berjalan</span>
      </a>
    </li>
  </ul>
@endsection
