function login(){
  var user = $("#username").val();
  var pass = $("#password").val();
  if(user!="" && pass!=""){
    generate_token();
    ajax_with_form("serialize","login","load");
    document.getElementById("username").focus();
    $("#username").val("");
    $("#password").val("");
  }else{
    swal({
      title: "Error",
      text: "Kolom username atau password masih kosong",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}
