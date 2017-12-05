@if(count($datas)>0)
  <script type="text/javascript">
    $("#username").removeClass("available");
    if(!$("#username").hasClass("notavailable")){
      $("#username").addClass("notavailable");
    }
    $("#tempusername").val(0);
  </script>
@else
  <script type="text/javascript">
    $("#username").removeClass("notavailable");
    if(!$("#username").hasClass("available")){
      $("#username").addClass("available");
    }
    $("#tempusername").val(1);
  </script>
@endif
