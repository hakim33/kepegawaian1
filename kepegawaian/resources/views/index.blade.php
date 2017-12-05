<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>PAW</title>
    <link rel="stylesheet" href="{!! asset("public/css/public.css")!!}">
    <link rel="stylesheet" href="{!! asset("public/css/index.css")!!}">
    <link rel="stylesheet" href="{!! asset("public/css/sweetalert.css")!!}">
    <script type="text/javascript" src="{!! asset("public/js/jquery.js")!!}"></script>
    <script type="text/javascript" src="{!! asset("public/js/public.js")!!}"></script>
    <script type="text/javascript" src="{!! asset("public/js/index.js")!!}"></script>
    <script type="text/javascript" src="{!! asset("public/js/sweetalert.min.js")!!}"></script>
  </head>
  <body>
    <div id="load"></div>
    <div id="form-login">
      <fieldset class="st1 fieldset">
        <div class="subjudul head_block">
          Nagreg Bangkit <span>Group</span>
        </div>
        <form id="serialize" method="post">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" value="" placeholder="Ketik disini" autofocus>
          <label for="password">Password:</label>
          <input type="password" onkeypress="last_form(event,'masuk')" id="password" name="password" value="" placeholder="Ketik disini">
          <div class="panel_tombol">
            <button type="button" id="masuk" onclick="login()" class="blue">Masuk</button>
          </div>
        </form>
      </fieldset>
    </div>
    <script type="text/javascript">
      @if(session()->has('message'))
        <script>
        swal({
          title: "{{session()->get('title')}}",
          text: "{{session()->get('message')}}",
          type: "{{session()->get('type')}}",
          confirmButtonColor: "#2b5dcd",
          confirmButtonText: "OK",
          closeOnConfirm: true
        });
        </script>

      @endif
    </script>
  </body>
</html>
