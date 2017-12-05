<html>
  <script>
    $( function() {
      $( ".datepicker" ).datepicker();
    } );
  </script>
  <body>
   
    <div id="content">
      <form id="serialize">
        <table class="data-table" id="data-pegawai">
          <thead>
            <tr>
              <th>Foto</th>
              <th colspan="2">Data Diri</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="bodycontent">
            <tr>
              <td style="text-align:center;vertical-align:top;min-width:300px;width:300px" rowspan="10">
                <div id="panel1" class="panelimgnewdata">
                  <img id="imgcrop" style="width:100%;" src="{!! asset('public/gambar/icon/unknown.png') !!}">
                </div>
                <div id="panel2" style="display:none" class="panelimgnewdata">
                  <img id="img" style="width:100%" src="{!! asset('public/gambar/icon/unknown.png') !!}">
                  <input type="hidden" name="tempimg" id="tempimg" value="1">
                </div>
                <button type="button" class="blue" id="tetapkan">Tetapkan</button>
                <button type="button" onclick="document.getElementById('maskbrowse').click()" class="blue" id="upload">Upload</button>
                <button type="button" onclick="delete_image()" class="red" id="hapus" disabled>Hapus</button>
                <input type="file" id="maskbrowse" class="maskbrowse" onchange="ValidateSingleInput(this)">
              </td>
              <th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Username</th>
              <td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">
                <input style="text-transform:none" class="inp_employee validasiicon" onkeypress="next_focus(event,'password')" onkeyup="search_username(this.value)" maxlength="15" type="text" name="username" id="username" value="">
                <input type="hidden" id="tempusername" value="0">
              </td>
              <td style="width:10%;text-align:center;vertical-align:top;" rowspan="10">
                <button type="button" title="Simpan data" onclick="save_data_baru()" autofocus class="save prosesbtn" id="save" name="button"></button><br><hr>
                <button type="reset" title="Reset data" class="reset prosesbtn" id="reset" name="button"></button><hr>
                <button type="button" onclick="show_data('show_data_pegawai')" id="cancel" title="Batalkan perubahan" class="cancel prosesbtn" name="button"></button>
              </td>
            </tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Password</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1"><input style="text-transform:none" onkeypress="next_focus(event,'nip')" onkeyup="cek_password(this.value)" title="Minimal 8 digit" placeholder="Minimal 8 digit" class="inp_employee validasiicon" type="password" onkeyup="" name="password" id="password" value=""></td></tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*NIP</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1"><input class="inp_employee validasiicon" maxlength="6" type="text" name="nip" id="nip" onkeypress="next_focus(event,'nama')" onkeyup="cek_nip(this.value)" value=""><input type="hidden" id="tempnip" value="0"></td></tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Nama</th><td style="width:calc(80% - 300px);border-bottom:1px solid #e1e1e1"><input class="inp_employee" maxlength="30" type="text" onkeypress="next_focus(event,'kelamin')" name="nama" id="nama" value=""></td></tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Kelamin</th>
              <td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">
                <select class="inp_employee" name="kelamin" id="kelamin" onkeypress="next_focus(event,'jabatan')">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="P">Pria</option>
                  <option value="W">Wanita</option>
                </select>
              </td>
            </tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">*Tanggal Masuk</th><td style="width:calc(80% - 300px);border-bottom:1px solid #e1e1e1"><input style="cursor:pointer" class="inp_employee datepicker" maxlength="10" type="text" readonly="readonly" name="tgl_masuk" id="tgl_masuk" value="{{$data->tgl_masuk}}"></td></tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Jabatan</th>
              <td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">
                <input class="inp_employee" type="text" maxlength="25" name="jabatan" onkeypress="next_focus(event,'gaji')" list="list-jabatan" id="jabatan" value="">
                <datalist id="list-jabatan">
                  @if(count($jobs)>0)
                    @foreach ($jobs as $job)
                      <option style="transform:capitalize" value="{{strtolower($job->jabatan)}}">{{strtolower($job->jabatan)}}</option>
                    @endforeach
                  @endif
                </datalist>
              </td>
            </tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Gaji</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">Rp. <input class="inp_employee" onkeypress="next_focus(event,'telepon')" onkeyup="just_number(this)" min="0" step="50000" style="width:calc(100% - 25px)" type="number" name="gaji" id="gaji" value=""></td></tr>
            <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Telepon</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1"><input class="inp_employee" onkeypress="next_focus(event,'alamat')" type="text" name="telepon" id="telepon" value=""></td></tr>
            <tr><th style="width:10%;background-color:#9a98f5;color:#1a1b33">Alamat</th><td style="width:calc(80% - 120px);"><textarea class="inp_employee" name="alamat" id="alamat">{{$data->alamat}}</textarea></td></tr>
          </tbody>
        </table>
      </form>
      <br>
    </div>
  </body>
</html>
