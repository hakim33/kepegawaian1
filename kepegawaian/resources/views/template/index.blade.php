<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Nageg Bangkit</title>
    <link rel="stylesheet" href="{!! asset('public/css/public.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/css/template.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/css/sweetalert.css') !!}">
    <script type="text/javascript" src="{!! asset('public/js/jquery.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('public/js/public.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('public/js/template.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('public/js/sweetalert.min.js') !!}"></script>
    @section('lib')
    @show
  </head>
  <body>
    <div id="load"></div>
    <div id="wrapper">
      <header>
        <button type="button" class="navbtn" onclick="navbar_proses()"></button>
        <label id="groupname" onclick="location.href='/'">Nagreg Bangkit <span>Group</span></label>
        @section("login")
        @show
      </header>
      <div id="sidebar" class="show_sidebar animasi">
        <nav style="display:block">
          @section("sidebar")
          @show
        </nav>
      </div>
      <div id="rightside" class="animasi">
        @section("content")
          @show
      </div>
    </div>
  </body>
</html>
