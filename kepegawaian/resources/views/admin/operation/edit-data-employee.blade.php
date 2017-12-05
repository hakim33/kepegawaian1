<html>
  <script>
    $( function() {
      $( ".datepicker" ).datepicker();
    } );
  </script>
  <body>
    <div id="content">
      <div id="content">
        @if (count($datas)>0)
          <form id="serialize" onreset="set_kelamin()">
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
                  <tr>
                    <td style="text-align:center;vertical-align:top;min-width:300px;width:300px" rowspan="8">
                      @if($stsfoto==1)
                        @php
                            $type = pathinfo($url, PATHINFO_EXTENSION);
                            $content = file_get_contents($url);
                            $url = 'data:image/'.$type.';base64,'.base64_encode($content);
                        @endphp
                        <div id="panel1" style="display:none" class="panelimgnewdata">
                          <img id="imgcrop" style="width:100%;height:350px" src="{!! asset('public/gambar/icon/unknown.png') !!}">
                        </div>
                        <div id="panel2" style="display:block" class="panelimgnewdata">
                          <img id="img" style="width:100%;height:350px" src="{{$url}}">
                          <input type="hidden" name="tempimg" id="tempimg" value="1">
                        </div>
                        <button type="button" class="blue" id="tetapkan">Tetapkan</button>
                        <button type="button" onclick="document.getElementById('maskbrowse').click()" class="blue" id="upload" disabled>Upload</button>
                        <button type="button" onclick="delete_image()" class="red" id="hapus">Hapus</button>
                      @else
                        <div id="panel1" class="panelimgnewdata">
                          <img id="imgcrop" style="width:100%;height:350px" src="{!! asset('public/gambar/icon/unknown.png') !!}">
                        </div>
                        <div id="panel2" style="display:none" class="panelimgnewdata">
                          <img id="img" style="width:100%;height:350px" src="{!! asset('public/gambar/icon/unknown.png') !!}">
                          <input type="hidden" name="tempimg" id="tempimg" value="1">
                        </div>
                        <button type="button" class="blue" id="tetapkan">Tetapkan</button>
                        <button type="button" onclick="document.getElementById('maskbrowse').click()" class="blue" id="upload">Upload</button>
                        <button type="button" onclick="delete_image()" class="red" id="hapus" disabled>Hapus</button>
                      @endif
                      <input type="file" id="maskbrowse" class="maskbrowse" onchange="ValidateSingleInput(this)">
                    </td>
                    <th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*NIP</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1"><input class="inp_employee validasiicon" onkeyup="cek_nip_edit(this.value)" maxlength="6" type="text" name="nip" id="nip" value="{{$data->nip}}"><input type="hidden" name="tempnip" id="tempnip2" value="{{$data->nip}}"></td>
                    <td style="width:10%;text-align:center;vertical-align:top" rowspan="8">
                      <button type="button" title="Simpan data" onclick="save_data()" class="save prosesbtn" name="button"></button><br><hr>
                      <button type="reset" title="Reset data" class="reset prosesbtn" name="button"></button><hr>
                      <button type="button" onclick="show_data('show_data_pegawai')" title="Batalkan perubahan" class="cancel prosesbtn" name="button"></button><hr>
                      <button type="button" onclick="hapus_data('{{$data->nip}}',0)" title="Hapus data" class="trash prosesbtn" name="button"></button>
                    </td>
                  </tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Nama</th><td style="width:calc(80% - 300px);border-bottom:1px solid #e1e1e1"><input class="inp_employee" maxlength="30" type="text" name="nama" id="nama" value="{{$data->nama}}"></td></tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Kelamin</th>
                    <td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">
                      <select class="inp_employee" name="kelamin" id="kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="P">Pria</option>
                        <option value="W">Wanita</option>
                      </select>
                      <input type="hidden" id="tempkelamin" value="{{$data->kelamin}}">
                      <script type="text/javascript">document.getElementById("kelamin").value="{{$data->kelamin}}"</script>
                    </td>
                  </tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Tanggal Masuk</th><td style="width:calc(80% - 300px);border-bottom:1px solid #e1e1e1"><input style="cursor:pointer" class="inp_employee datepicker" maxlength="10" type="text" readonly="readonly" name="tgl_masuk" id="tgl_masuk" value="{{$data->tgl_masuk}}"></td></tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Jabatan</th>
                    <td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">
                      <input class="inp_employee" type="text" maxlength="25" name="jabatan" list="list-jabatan" id="jabatan" value="{{strtolower($data->jabatan)}}">
                      <datalist id="list-jabatan">
                        @foreach ($jobs as $job)
                          <option style="transform:capitalize" value="strtolower($job->jabatan)">{{strtolower($job->jabatan)}}</option>
                        @endforeach
                      </datalist>
                    </td>
                  </tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Gaji</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">Rp. <input class="inp_employee" onkeyup="just_number(this)" min="0" step="50000" style="width:calc(100% - 25px)" type="number" name="gaji" id="gaji" value="{{$data->gaji}}"></td></tr>
                  <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Telepon</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1"><input class="inp_employee" type="text" name="telepon" id="telepon" value="{{$data->telepon}}"></td></tr>
                  <tr><th style="width:10%;background-color:#9a98f5;color:#1a1b33">Alamat</th><td style="width:calc(80% - 120px);"><textarea class="inp_employee" name="alamat">{{$data->alamat}}</textarea></td></tr>
                @endforeach
              </tbody>
            </table>
          </form>
          <br>
        @endif
    </div>
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
      <?php session()->forget('message');?>
    @endif
  </body>
</html>
