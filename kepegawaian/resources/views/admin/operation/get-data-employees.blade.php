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
            $img = file_get_contents($url);
            $url = 'data:image/'.$type.';base64,'.base64_encode($img);
          }else{
            if($data->kelamin == 'P'){
              $url = asset("public/gambar/icon/employee-notfound.png");
            }else{
              $url = asset("public/gambar/icon/employee-notfound-w.png");
            }
          }
        @endphp
        <tr>
          <td width="120px" rowspan="4">
            <div class="panelimg">
              <img class="thumbnail" src="{{ $url }}">
            </div>
          </td>
          <th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">NIP</th><td style="width:calc(80% - 120px);border-bottom:none">{{$data->nip}}</td>
          <td style="width:10%;text-align:center" rowspan="4">
            @if ($sts==1)
              <button type="button" title="Detail data" onclick="show_detail('{{$data->nip}}',0)" class="detail_data prosesbtn" name="button"></button><br><hr>
              <button type="button" title="Edit data" onclick="edit_data('{{$data->nip}}')" class="edit prosesbtn" name="button"></button><br><hr>
              <button type="button" onclick="hapus_data('{{$data->nip}}',0)" title="Hapus data" class="trash prosesbtn" name="button"></button>
            @else
              <button type="button" title="Detail data" onclick="show_detail('{{$data->nip}}',1)" class="detail_data prosesbtn" name="button"></button><br><hr>
              <button type="button" onclick="restore_data('{{$data->nip}}')" title="Restore data" class="restore prosesbtn" name="button"></button><br><hr>
              <button type="button" onclick="hapus_data('{{$data->nip}}',1)" title="Hapus data" class="trash prosesbtn" name="button"></button>
            @endif
          </td>
        </tr>
        <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Nama</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{$data->nama}}</td></tr>
        <tr><th style="width:10%;border-bottom:1px solid #e1e1e1;background-color:#9a98f5;color:#1a1b33">Jabatan</th><td style="width:calc(80% - 120px);border-bottom:1px solid #e1e1e1">{{strtolower($data->jabatan)}}</td></tr>
        <tr><th style="width:10%;background-color:#9a98f5;color:#1a1b33">Gaji</th><td style="width:calc(80% - 120px);">Rp. {{number_format($data->gaji,0,",",".")}}</td></tr>
      @endforeach
    </tbody>
  </table>
  <br>
  <div class="judulblock">Halaman:</div>
  <div id="page">
    @php
      if(count($counts)>0){
        foreach ($counts as $count);
        $jumpage = intval($count->jum/5);
        if($count->jum % 5 !=0){
          $jumpage++;
        }
        $skip = 0;
        for ($i=1;$i<=$jumpage;$i++) {
          echo "<button id='$i' onclick='change_page($i,$skip,$sts)' type='button'>$i</button>";
          $skip = $skip + 5;
        }
      }
    @endphp
    <script type="text/javascript">
      $("#1").addClass("active-history");
    </script>
    <input type="hidden" id="temppage" value="1">
  </div>
  <br>
@else
  <center>
    <div class="message">
      {{$pesan}}
    </div>
  </center>
@endif
