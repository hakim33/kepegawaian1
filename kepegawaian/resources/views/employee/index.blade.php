@extends('template.index')

@section('lib')
  <script type="text/javascript" src="{!! asset('public/js/employee.js') !!}"></script>
  <link rel="stylesheet" href="{!!asset('public/css/croppie.css')!!}" />
  <link rel="stylesheet" href="{!!asset('public/css/employee.css')!!}" />
  <script src="{!!asset('public/js/croppie.js')!!}"></script>
  <script src="{!!asset('public/js/jquery-ui.js')!!}"></script>
  <link rel="stylesheet" href="{!!asset('public/css/jquery-ui.css')!!}" />
@endsection

@section('content')
  @include('employee.operation.dashboard')
@endsection

@section('login')
  <div id="userlogin" onclick="show_optionlogin();">
    @php
      if($url != asset("/public/gambar/icon/unknown.png")){
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
  
    {{-- menu2 --}}
    <li id="parent1" onclick="show_nav_menu('parent1','second_menu1')" class="first-child employee icon">
      <div class="animasi"></div>
      <a href="#">
        <span>Kepegawaian</span>
      </a>
    </li>
    <li>
      <ul id="second_menu1">
        <li class="dataemployee icon" onclick="edit_data()">Data Pegawai</li>
        <li class="grayfolder icon" onclick="show_data('show_berkas')">Berkas Pegawai</li>
      </ul>
    </li>
    {{-- menu3 --}}
    <li id="parent2" class="first-child group icon" onclick="show_nav_menu('parent2','second_menu2')">
      <div class="animasi"></div>
      <a href="#">
        <span>Olah Proyek</span>
      </a>
    </li>
    <li>
      <ul id="second_menu2">
        <li class="task icon" onclick="show_data('show_proyek')">Proyek Berjalan</li>
        <li class="jobs icon" onclick="show_data('make_proyek')">Buat Proyek</li>
      </ul>
    </li>
    {{-- menu4 --}}
    <li onclick="show_data('show_absensi')" class="first-child list icon">
      <a href="#">
        <span>Absensi</span>
      </a>
    </li>
  </ul>
@endsection
