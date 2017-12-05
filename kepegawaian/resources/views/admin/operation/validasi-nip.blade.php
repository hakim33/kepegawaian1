@if(count($datas)>0)
  <script type="text/javascript">
    $("#nip").removeClass("available");
    if(!$("#nip").hasClass("notavailable")){
      $("#nip").addClass("notavailable");
    }
    $("#tempnip").val(0);
  </script>
@else
  <script type="text/javascript">
    $("#nip").removeClass("notavailable");
    if(!$("#nip").hasClass("available")){
      $("#nip").addClass("available");
    }
    $("#tempnip").val(1);
  </script>
@endif
