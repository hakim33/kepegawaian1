@if(count($datas)>0)
  @foreach ($datas as $data)
    <option value="{{$data->nip}}">{{strtolower($data->nama)}}</option>
  @endforeach
@endif
