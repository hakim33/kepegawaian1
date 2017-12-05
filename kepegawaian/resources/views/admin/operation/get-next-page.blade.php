@if(count($datas)>0)
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
@endif
