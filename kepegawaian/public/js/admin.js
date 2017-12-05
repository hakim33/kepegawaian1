function np_date(obj){
  date = document.getElementById("tglabsen").value;
  date = new Date(date);
  var add = $(obj).hasClass('increase_date') ? 1 : -1;
  date.setDate(date.getDate()+add);
  document.getElementById("tglabsen").value = date.yyyymmdd();
  change_absen(date.yyyymmdd());
}

function detail_project(no){
  ajax_operation("get","admin/show-project/"+no,"rightside");
}

function show_berkas(nip,sts){
  ajax_operation("get","admin/show-berkas/"+nip+"/"+sts,"rightside");
}

function hapus_absensi(){
  if(document.getElementById("data-pegawai")!=null){
    swal({
      title: "Hapus Data",
      text: "Hapus absen ini?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#952828",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
    },
    function(isConfirm){
      if(isConfirm){
        var date = $("#tglabsen").val();
        generate_token();
        ajax_operation("post","admin/delete-absence/"+date,"content");
      }
    });
  }else{
    swal({
      title: "Error",
      text: "Tidak ada absensi yang dapat dihapus",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function buat_absensi(){
  if(document.getElementById("data-pegawai")==null){
    var date = $("#tglabsen").val();
    generate_token();
    ajax_operation("post","admin/make-absence/"+date,"content");
  }else{
    swal({
      title: "Error",
      text: "Absensi telah dibuat",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function change_absen(date){
  ajax_operation("get","admin/next-absen/"+date,"content");
}

function set_rad(id,no,nip){
  document.getElementById(id).checked = true;
  switch (id.substr(0,1)) {
    case "h":
      document.getElementById("sts"+no).innerHTML = "Hadir";
      $("#sts"+no).addClass("greensts");
      $("#sts"+no).removeClass("bluests");
      $("#sts"+no).removeClass("redsts");
      $("#sts"+no).removeClass("orangests");
    break;
    case "s":
      document.getElementById("sts"+no).innerHTML = "Sakit";
      $("#sts"+no).removeClass("greensts");
      $("#sts"+no).addClass("bluests");
      $("#sts"+no).removeClass("redsts");
      $("#sts"+no).removeClass("orangests");
    break;
    case "i":
      document.getElementById("sts"+no).innerHTML = "Izin";
      $("#sts"+no).removeClass("greensts");
      $("#sts"+no).removeClass("bluests");
      $("#sts"+no).removeClass("redsts");
      $("#sts"+no).addClass("orangests");
    break;
    case "a":
      document.getElementById("sts"+no).innerHTML = "Alfa";
      $("#sts"+no).removeClass("greensts");
      $("#sts"+no).removeClass("bluests");
      $("#sts"+no).addClass("redsts");
      $("#sts"+no).removeClass("orangests");
    break;
  }
  date = $("#tglabsen").val();
  generate_token();
  ajax_operation("post","admin/save-absensi/"+nip+"/"+id.substr(0,1)+'/'+date,"");
}

function save_data_baru(){
  var stsusername = $("#tempusername").val();
  var stsnip = $("#tempnip").val();
  if($("#password").val().length>=8){
    var stspass = 1;
  }else{
    var stspass = 0;
  }
  if((stsusername==1)&&($("#tgl_masuk").val()!="")&&(stsnip==1)&&(stspass==1)&&($("#kelamin").val()!="")&&($("#nama").val()!="")){
    generate_token();
    ajax_with_form("serialize","admin/save-new-data","rightside");
  }else{
    swal({
      title: "Error",
      text: "Terdapat kolom isian yang salah atau data penting (*) yang masih kosong",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function search_username(val){
  if(val.length>=8){
    ajax_operation("get","admin/search-username/"+val,"load");
  }else{
    $("#username").removeClass("available");
    $("#username").removeClass("notavailable");
  }
}

function cek_password(val){
  if(val.length>=8){
    $("#password").removeClass("notavailable");
    if(!$("#password").hasClass("available")){
      $("#password").addClass("available");
    }
  }else if(val.length!=""){
    $("#password").removeClass("available");
    $("#password").addClass("notavailable");
  }else{
    $("#password").removeClass("notavailable");
  }
}

function cek_nip_edit(val){
  if($("#tempnip2").val()!=val){
    if(val.length==6){
      ajax_operation("get","admin/search-nip/"+val,"load");
    }
  }else{
    $("#nip").removeClass("available");
    $("#nip").removeClass("notavailable");
  }
}

function cek_nip(val){
  if(val.length==6){
    ajax_operation("get","admin/search-nip/"+val,"load");
  }else{
    $("#nip").removeClass("available");
    $("#nip").removeClass("notavailable");
    $("#tempnip").val(0);
  }
}

function delete_this_berkass(namafile,nip,sts){
  swal({
    title: "Hapus Data",
    text: "Hapus file '"+namafile+"' ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      ajax_operation("get","admin/delete-berkas/"+namafile+"/"+nip+"/"+sts,"rightside");
    }
  });
}

function show_detail(nip,sts){
  ajax_operation("get","admin/detail-pegawai/"+nip+"/"+sts,"rightside");
}

function add_new_data(){
  ajax_operation("get","admin/add-new-data","rightside");
}

function save_data(){
  var nip = $("#nip").val();
  var nama = $("#kelamin").val();
  var kelamin = $("#nama").val();
  var tgl = $("#tgl_masuk").val();
  if((nip!="")&&(nama!="")&&(kelamin!="")&&(tgl!="")){
    generate_token();
    ajax_with_form("serialize","admin/save-data","load");
  }else{
    swal({
      title: "Error",
      text: "Terdapat kolom isian yang salah atau data penting (*) yang masih kosong",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function set_kelamin(){
  setTimeout(function(){document.getElementById("kelamin").value= $("#tempkelamin").val();},10);
}

function change_page(no,skip,sts){
  tempno = $("#temppage").val();
  if(no!=tempno){
    $("#"+tempno).toggleClass("active-history");
    $("#temppage").val(no);
    $("#"+no).toggleClass("active-history");
    if($("#inpsearch").val()==""){
      ajax_operation("get","admin/next-data-employees/"+no+"/"+skip+"/"+sts,"bodycontent");
    }else{
      ajax_operation("get","admin/next-data-employees-with-page/"+no+"/"+skip+"/"+sts+"/"+$("#inpsearch").val(),"bodycontent");
    }
  }
}

function edit_data(nip){
  ajax_operation("get","admin/edit-data/"+nip,"rightside");
}

function show_data(sts){
  ajax_operation("get","admin/tampil-data/"+sts,"rightside");
}

function restore_data(nip){
  swal({
    title: "Restore Data",
    text: "Restore data pegawai dengan nip "+nip+" ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      generate_token();
      ajax_operation("post","admin/restore-data/"+nip,"rightside");
    }
  });
}

function hapus_data(nip,sts){
  swal({
    title: "Hapus Data",
    text: "Hapus data pegawai dengan nip "+nip+" ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      generate_token();
      ajax_operation("post","admin/hapus-data/"+nip+"/"+sts,"rightside");
    }
  });
}
