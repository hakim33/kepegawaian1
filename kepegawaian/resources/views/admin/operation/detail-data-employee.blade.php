<html>
  <body>
    <div class="header-content">
      <ul id="pintasan">
        <a href="admin"><li class="home">Home</li><span>|</span></a>
        <a href="#"><li style="cursor:default">Olah Data Pegawai</li><span>|</span></a>
        @if ($sts==1)
          <a href="#"><li onclick="show_data('show_data_pegawai')">Lihat Data Pegawai</li><span>|</span></a>
        @else
          <a href="#"><li onclick="show_data('show_data_trash')">Sampah Data Pegawai</li><span>|</span></a>
        @endif
        <a href="#"><li class="active-history">Data Pegawai {{$nip}}</li></a>
      </ul>
    </div>
    <div id="content">
      <div id="content">
        @if (count($datas)>0)
          <table class="data-table" id="data-pegawai">
            <thead>
              <tr>
                <th>Foto</th>
                <th colspan="2">Data Diri</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="bodycontent">
              @foreach ($datas as $data)
                @php
                  if (file_exists("storage/app/public/foto/".$data->nip.'.jpeg')) {
                      $url = "storage/app/public/foto/$data->nip.jpeg";
                      $type = pathinfo($url, PATHINFO_EXTENSION);
                      $content = file_get_contents($url);
                      $url = 'data:image/'.$type.';base64,'.base64_encode($content);
                    if($data->kelamin == 'P'){
                      $kelamin = "Pria";
                    }else{
                      $kelamin = "Wanita";
                    }
                  }else{
                    if($data->kelamin == 'P'){
                      $url = asset("public/gambar/icon/employee-notfound.png");
                      $kelamin = "Pria";
                    }else{
                      $url = asset("public/gambar/icon/employee-notfound-w.png");
                      $kelamin = "Wanita";
                    }
                  }
                @endphp
                <tr>
                  <td width="300px" rowspan="8">
                    <div style="height:auto" class="panelimg">
                      <img style="width:300px" src="{{ $url }}">
                    </div>
                  </td>
                  <th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">NIP</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{$data->nip}}</td>
                  <td style="width:10%;text-align:center;vertical-align:top" rowspan="8">
                    @if ($sts==1)
                      <button type="button" title="Edit data" onclick="edit_data('{{$data->nip}}')" class="edit prosesbtn" name="button"></button><br><hr>
                      <button type="button" class="bluefolder prosesbtn" id="berkas" title="Berkas pegawai" onclick="show_berkas('{{$data->nip}}',{{$sts}})"></button><hr>
                      <button type="button" onclick="hapus_data('{{$data->nip}}',0)" title="Hapus data" class="trash prosesbtn" name="button"></button>
                    @else
                      <button type="button" onclick="restore_data('{{$data->nip}}')" title="Restore data" class="restore prosesbtn" name="button"></button><br><hr>
                      <button type="button" class="bluefolder prosesbtn" id="berkas" title="Berkas pegawai" onclick="show_berkas('{{$data->nip}}',{{$sts}})"></button><hr>
                      <button type="button" onclick="hapus_data('{{$data->nip}}',1)" title="Hapus data" class="trash prosesbtn" name="button"></button>
                    @endif
                  </td>
                </tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Nama</th><td style="width:calc(80% - 300px);border-bottom:1px solid #e1e1e1">{{$data->nama}}</td></tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Kelamin</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{$kelamin}}</td></tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Tanggal Masuk</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{$data->tgl_masuk}}</td></tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Jabatan</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{strtolower($data->jabatan)}}</td></tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Gaji</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">Rp. {{number_format($data->gaji,0,",",".")}}</td></tr>
                <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Telepon</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{$data->telepon}}</td></tr>
                <tr><th style="width:10%;background-color:#9a98f5;color:#1a1b33">Alamat</th><td style="width:calc(80% - 120px);">{{$data->alamat}}</td></tr>
              @endforeach
            </tbody>
          </table>
        @endif
    </div>
  </body>
</html>
