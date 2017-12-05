function change_password(){
  ajax_operation("get","admin/show-int-change-pass","rightside");
}


function change_color_status(id,no){
  switch (id) {
    case "h":
      document.getElementById("sts"+no).innerHTML = "Hadir";
      $("#sts"+no).addClass("greensts");
    break;
    case "s":
      document.getElementById("sts"+no).innerHTML = "Sakit";
      $("#sts"+no).addClass("bluests");
    break;
    case "i":
      document.getElementById("sts"+no).innerHTML = "Izin";
      $("#sts"+no).addClass("orangests");
    break;
    case "a":
      document.getElementById("sts"+no).innerHTML = "Alfa";
      $("#sts"+no).addClass("redsts");
    break;
  }
}

function expand_search(id,sts){
  if(sts==1){
    $("."+id).eq(0).addClass("expand_search");
  }else if($("#inpsearch").val()==""){
    $("."+id).eq(0).removeClass("expand_search");
  }
}

function set_kelamin(){
  setTimeout(function(){document.getElementById("kelamin").value= $("#tempkelamin").val();},10);
}

function delete_image(){
  var hapus = document.getElementById('hapus');
  var unggah = document.getElementById('upload');
  var tetapkan = document.getElementById("tetapkan");
  swal({
    title: "Hapus Data",
    text: "Hapus foto ini?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#952828",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  },
  function(isConfirm){
    if(isConfirm){
      document.getElementById("panel1").style.display = "block";
      document.getElementById("panel2").style.display = "none";
      hapus.disabled = true;
      unggah.disabled = false;
      document.getElementById("tempimg").value = "";
      if($(".croppie-container")[0]!=null){
        var img_edit = document.getElementById("panel1");
        img_edit.removeChild(document.getElementsByClassName("croppie-container")[0]);
        var img = document.createElement("img");
        img.id = "imgcrop";
        img.style = "width:100%";
        img.src = "public/gambar/icon/unknown.png";
        document.getElementById("img").src = "public/gambar/icon/unknown.png";
        img_edit.appendChild(img);
      }
    }
  });
}

function search_employee(val,sts){
  if(val!=""){
    clearTimeout(typingtimer);
    setTimeout(function(){ajax_operation("get","admin/search-employee/"+val+"/"+sts,"bodycontent");},2000);
  }
}

function next_focus(evt,id){
  if(evt.keyCode==13){
    document.getElementById(id).focus();
  }
  if(evt.keyCode==9){
    setTimeout(function(){document.getElementById(id).focus();},10);
  }
}

function last_form(evt,btnname){
  if(evt.keyCode==13)
    document.getElementById(btnname).click();
}

Number.prototype.formatMoney = function(c, d, t){
var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

 Date.prototype.yyyymmdd = function() {
   var mm = this.getMonth() + 1; // getMonth() is zero-based
   var dd = this.getDate();

   return [this.getFullYear(),
           (mm>9 ? '' : '0')+mm,
           (dd>9 ? '' : '0')+dd
         ].join('-');
 };

function search_data(obj,table){
  var $rows = $('#'+table+' tbody tr');
  var val = $.trim($(obj).val()).replace(/ +/g, ' ').toLowerCase();

  $rows.show().filter(function() {
      var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
      return !~text.indexOf(val);
  }).hide();
}

function just_number(obj){
  obj.value = obj.value.replace(/[^0-9]/g,'');
  if(obj.value==""){
    obj.value=0;
    obj.setAttribute("data-value",0);
  }
  return true;
}

function ajax_operation(tipe,url,content){
  $.ajax({
    type: tipe,
    url: url,
    beforeSend  : function(){
        $("#load").show();
      },
    success: function(data){
      $("#load").hide();
      if((content!="")&&(content!=1)){
        $("#"+content).html(data);
      }else if(content==1){
        location.reload(true);
      }
    }
  });
}

function ajax_with_form(formname,url,content){
  var form = $('#'+formname)[0];
  var frdata = new FormData(form);
  $.ajax({
    type: "POST",
    data: frdata,
    url: url,
    contentType: false,
    processData: false,
    beforeSend  : function(){
        $("#load").show();
      },
    success: function(data){
      $("#load").hide();
      if((content!="")&&(content!=1)){
        $("#"+content).html(data);
      }else if(content==1){
        location.reload(true);
      }
    }
  });
}

function save_new_password(){
  var lastpass = $("#lastpassword").val();
  var newpass = $("#newpassword").val();
  var repass = $("#repassword").val();
  if((lastpass!="")&&(newpass!="")&&(repass!="")){
    if(lastpass != newpass){
      if(newpass == repass){
        generate_token();
        ajax_with_form("serialize","admin/save-password","load");
      }else{
        swal({
          title: "Error",
          text: "Password baru tidak sama dengan pengulangannya",
          type: "error",
          confirmButtonColor: "#2b5dcd",
          confirmButtonText: "OK",
          closeOnConfirm: true
        });
      }
    }else{
      swal({
        title: "Error",
        text: "Password lama dengan password baru sama",
        type: "error",
        confirmButtonColor: "#2b5dcd",
        confirmButtonText: "OK",
        closeOnConfirm: true
      });
    }
  }else{
    swal({
      title: "Error",
      text: "Masih terdapat kolom isian yang kosong",
      type: "error",
      confirmButtonColor: "#2b5dcd",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  }
}

function generate_token(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}

function PreviewImage() {
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById('maskbrowse').files[0]);
  oFReader.onload = function (oFREvent) {
    document.getElementById('imgcrop').src = oFREvent.target.result;
    var image = $('#imgcrop').croppie({
        enableExif: true,
        viewport: {
            width: 94,
            height: 94,
            type: 'rectangle'
        },
        boundary: {
            width: 100,
            height: 100
        }
    });
    $('#tetapkan').on('click', function (ev){
     image.croppie('result',{
       type: 'canvas',
       size: 'original'
     }).then(function (resp){
       document.getElementById('upload').style.display = "inline-block";
       document.getElementById('hapus').style.display = "inline-block";
       document.getElementById('tetapkan').style.display = "none";
       document.getElementById('tetapkan').disabled = true;
       document.getElementById('hapus').disabled = false;
       document.getElementById("panel1").style.display = "none";
       document.getElementById("panel2").style.display = "block";
       $('#img').attr('src',resp);
       $('#tempimg').val(resp);
     });
   });
  };
};

function ValidateSingleInput(oInput) {
  var _validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
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
            document.getElementById("tetapkan").disabled = false;
            document.getElementById("upload").disabled = true;
            document.getElementById("upload").style.display = "none";
            document.getElementById("hapus").disabled = true;
            document.getElementById("hapus").style.display = "none";
            document.getElementById("tetapkan").style.display = "inline-block";
            PreviewImage();
          }
      }
  }
  return true;
}
