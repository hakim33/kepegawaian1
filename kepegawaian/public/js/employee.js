function edit_data(){
  ajax_operation("get","pegawai/edit-data","rightside");
}

function detail_project(no){
  ajax_operation("get","pegawai/show-project/"+no,"rightside");
}

function simpan_ubah(sts,no){
  generate_token();
  if(sts==0){
    var nama = document.getElementById("nama0").value;
    var tgl_mulai = document.getElementById("tgl_mulai0").value;
    var tgl_selesai = document.getElementById("tgl_selesai0").value;
    var tbl = document.getElementById("anggota");
    var rows = tbl.rows.length-1;
    var status = 1;
    for (var i=1;i<=rows;i++) {
      if(document.getElementById("nip"+i).value==""){
        status = 0;
        break;
      }
    }
    if((nama!="")&&(tgl_mulai!="")&&(tgl_selesai!="")&&(status==1)){
      ajax_with_form("serialize2","pegawai/update-project/"+sts+"/"+no,"rightside");
    }else{
      swal({
        title: "Error",
        text: "Masih terdapat kolom kosong",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }
  }else{
    var nama = document.getElementById("nama").value;
    var tgl_mulai = document.getElementById("tgl_mulai").value;
    var tgl_selesai = document.getElementById("tgl_selesai").value;
    if((nama!="")&&(tgl_mulai!="")&&(tgl_selesai!="")){
      ajax_with_form("serialize1","pegawai/update-project/"+sts+"/"+no,"rightside");
    }else{
      swal({
        title: "Error",
        text: "Masih terdapat kolom kosong",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }
  }
}

function done_project(no){
  swal({
    title: "Simpan Data",
    text: "Proyek yang selesai tidak dapat diolah lagi\nSimpan proyek sebagai proyek selesai ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      generate_token();
      ajax_operation("post","pegawai/done-project/"+no,"rightside");
    }
  });
}

function edit_project(no){
  ajax_operation("get","pegawai/edit-project/"+no,"rightside");
}

function delete_proyek(no){
  swal({
    title: "Hapus Data",
    text: "Hapus proyek ini ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      generate_token();
      ajax_operation("post","pegawai/delete-project/"+no,"rightside");
    }
  });
}

function show_form_individu(){
  $("#serialize1").removeClass("hide");
  $("#serialize2").addClass("hide");
}

function checkall(obj){
  var tbl = document.getElementById("anggota");
  var rows = tbl.rows.length;
  if(obj.checked){
    var cek = true;
    document.getElementById("hapus").disabled = false;
    $("#tempcek").val(tbl.rows.length-1);
  }else{
    var cek = false;
    document.getElementById("hapus").disabled = true;
    $("#tempcek").val(0);
  }
  for (var i=1;i<=rows;i++) {
    document.getElementById("cek"+i).checked = cek;
  }
}

function save_project(sts){
  generate_token();
  if(sts==0){
    var nama = document.getElementById("nama0").value;
    var tgl_mulai = document.getElementById("tgl_mulai0").value;
    var tgl_selesai = document.getElementById("tgl_selesai0").value;
    var tbl = document.getElementById("anggota");
    var rows = tbl.rows.length-1;
    var status = 1;
    for (var i=1;i<=rows;i++) {
      if(document.getElementById("nip"+i).value==""){
        status = 0;
        break;
      }
    }
    if((nama!="")&&(tgl_mulai!="")&&(tgl_selesai!="")&&(status==1)){
      ajax_with_form("serialize2","pegawai/save-project/"+sts,"rightside");
    }else{
      swal({
        title: "Error",
        text: "Masih terdapat kolom kosong",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }
  }else{
    var nama = document.getElementById("nama").value;
    var tgl_mulai = document.getElementById("tgl_mulai").value;
    var tgl_selesai = document.getElementById("tgl_selesai").value;
    if((nama!="")&&(tgl_mulai!="")&&(tgl_selesai!="")){
      ajax_with_form("serialize1","pegawai/save-project/"+sts,"rightside");
    }else{
      swal({
        title: "Error",
        text: "Masih terdapat kolom kosong",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }
  }
}

function reindex(tbl){
  for (var j=1;j<tbl.rows.length;j++) {
    tbl.rows[j].cells[0].children[0].id = "cek"+j;
    tbl.rows[j].cells[0].children[0].name = "cek"+j;
    tbl.rows[j].cells[1].innerHTML = "NIP Anggota "+j;
    tbl.rows[j].cells[2].children[0].id = "nip"+j;
    tbl.rows[j].cells[2].children[0].name = "nip"+j;
  }
}

function active_tgl(sts){
  if(sts == 1){
    document.getElementById("tgl_selesai").disabled = false;
  }else{
    document.getElementById("tgl_selesai0").disabled = false;
  }
}

function cek_date(obj,sts){
  if(sts==1){
    var mulai = document.getElementById("tgl_mulai").value;
    var d1 = new Date(mulai).yyyymmdd();
    var d2 = new Date(obj.value).yyyymmdd();
    if(d1>d2){
      document.getElementById("tgl_selesai").value = "";
      swal({
        title: "Error",
        text: "Tanggal selesai proyek tidak benar",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }else{

    }
  }else{
    var mulai = document.getElementById("tgl_mulai0").value;
    var d1 = new Date(mulai).yyyymmdd();
    var d2 = new Date(obj.value).yyyymmdd();
    if(d1>d2){
      document.getElementById("tgl_selesai0").value = "";
      swal({
        title: "Error",
        text: "Tanggal selesai proyek tidak benar",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }else{

    }
  }
}

function delete_row(){
  var tbl = document.getElementById("anggota");
  var rows = tbl.rows.length;
  var jum = 0;
  for (var i=1;i<rows;i++) {
    if(document.getElementById("cek"+i).checked){
      tbl.deleteRow(i-jum);
      jum++;
    }
  }
  reindex(tbl);
}

function tambah_baris(tblname){
  var tbl = $(tblname)[0];
  var row = tbl.insertRow(tbl.rows.length);
  var th = new Array(
              document.createElement("th"),
              document.createElement("th"));
  th[0].width = "5%";
  th[0].style.textAlign = "center";
  th[0].appendChild(generateCheckbox(row.rowIndex));

  th[1].innerHTML = "NIP Anggota "+(tbl.rows.length-1);
  var td = document.createElement("td");
  td.appendChild(generateInpText(row.rowIndex));
  row.appendChild(th[0]);
  row.appendChild(th[1]);
  row.appendChild(td);
}

function cek_centang(obj){
  if(obj.checked){
    $("#tempcek").val(parseInt($("#tempcek").val())+1);
    document.getElementById("hapus").disabled = false;
  }else{
    $("#tempcek").val(parseInt($("#tempcek").val())-1);
    if($("#tempcek").val()=="0"){
      document.getElementById("hapus").disabled = true;
    }
  }
}

function generateCheckbox(index){
  var idx   = document.createElement("input");
  idx.type  = "checkbox";
  idx.name  = "cek"+index;
  idx.id    = "cek"+index;
  idx.setAttribute("onclick","cek_centang(this)");
  return idx;
}

function generateInpText(index){
  var idx   = document.createElement("input");
  idx.type  = "text";
  idx.name  = "nip"+index;
  idx.id    = "nip"+index;
  idx.setAttribute("maxlength","6");
  idx.style.marginBottom = "0px";
  return idx;
}

function show_form_group(){
  $("#serialize2").removeClass("hide");
  $("#serialize1").addClass("hide");
}

function save_data(){
  generate_token();
  ajax_with_form("serialize","pegawai/save-data","load");
}

function show_data(sts){
  ajax_operation("get","pegawai/tampil-data/"+sts,"rightside");
}

function set_tanggal(){
  var tahun = document.getElementById("tahun").value;
  var bulan = document.getElementById("bulan").value;
  ajax_operation("get","pegawai/set-tanggal/"+bulan+"/"+tahun,"content");
}

function delete_this_berkas(namafile){
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
      ajax_operation("get","pegawai/delete-berkas/"+namafile,"rightside");
    }
  });
}

function validate_berkas(oInput) {
  var _validFileExtensions = [".pdf", ".doc", ".docx", ".xls",".xlsx",".ppt",".pptx",".ppsx",".txt",".rar"];
  if (oInput.type == "file") {
      var sFileName = oInput.value;
       if (sFileName.length > 0) {
          var blnValid = false;
          for (var j = 0; j < _validFileExtensions.length; j++) {
              var sCurExtension = _validFileExtensions[j];
              if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                  blnValid = true;
                  break;
              }
          }
          if (!blnValid) {
              swal({
                title: "Error",
                text: "Maaf,"+sFileName+" ekstensi file ini tidak cocok,\nberikut ekstensi yang diizinkan "+_validFileExtensions.join(", "),
                type: "error",
                confirmButtonColor: "#2b5dcd",
                confirmButtonText: "OK",
                closeOnConfirm: true
              });
              oInput.value = "";
              return false;
          }else{
            document.getElementById("pathberkas").value = document.getElementById("cariberkas").value;
            document.getElementById("hapusbtn").disabled = false;
            document.getElementById("uploadbtn").disabled = false;
            document.getElementById("cariberkasbtn").disabled = true;
          }
      }
  }
  return true;
}

function upload_berkas(){
  var file = document.getElementById("cariberkas").value;
  if(file!=""){
    generate_token();
    ajax_with_form("serialize","pegawai/upload-berkas","rightside");
  }else{
    swal({
      title: "Error",
      text: "Tidak ada file yang dapat diupload",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function delete_berkas(){
  document.getElementById("cariberkas").value = "";
  document.getElementById("pathberkas").value = "";
  document.getElementById("hapusbtn").disabled = true;
  document.getElementById("uploadbtn").disabled = true;
  document.getElementById("cariberkasbtn").disabled = false;
}
