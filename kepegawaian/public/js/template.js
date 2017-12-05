function navbar_proses(){
  $("#sidebar").toggleClass("show_sidebar");
  $("#rightside").toggleClass("expand_rightside");
}

function show_nav_menu(parentid,id){
  $("#"+parentid+" div").toggleClass("rotatearrow");
  $("#"+parentid).toggleClass("show_nav");
  $("#"+id).toggleClass("show_second_menu");
}

function show_optionlogin(){
    $("#optionlogin").toggleClass("hide");
}

function logout(){
  ajax_operation("get","logout",1);
}
