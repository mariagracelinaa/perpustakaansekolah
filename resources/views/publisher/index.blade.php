<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div class="container">
  @if(session('status'))
    {{-- Alert start --}}
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{session('status')}}
        </div>
    {{-- Alert End --}}
  @endif
  <h2>Daftar Penerbit</h2>
  <a href="#modalCreate" data-toggle="modal" class="btn btn-info">+ Tambah Data</a>         
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Penerbit</th>
        <th>Kota</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($result as $publisher)
        <tr>
          <td>{{$publisher->name}}</td>
          <td>{{$publisher->city}}</td>
          <td>
            <a href="#modalEdit" data-toggle="modal" class="btn btn-warning" onclick="getEditForm({{$publisher->id}})">Ubah</a>
            {{-- <a href="{{url('daftar-penerbit/'.$publisher->id.'/edit')}}" data-toggle="modal" class="btn btn-warning" onclick="getEditForm({{$publisher->id}})">Ubah</a> --}}
            <a class="btn btn-danger" onclick="if(confirm('Apakah anda yakin menghapus data {{$publisher->name}}'))">Hapus</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>


{{-- Modal start Add--}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" >
      {{-- Form start --}}
      <form role="form" method="POST" action="{{url('daftar-penerbit')}}">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Penerbit</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Penerbit</label>
                    <input type="text" class="form-control" placeholder="Isikan nama penerbit" name="name">
                    <span class="help-block">
                    Tulis nama penerbit dengan lengkap</span>
                </div>
                <div class="form-group">
                    <label>Kota Penerbit</label>
                    <input type="text" class="form-control" placeholder="Isikan kota penerbit" name="city">
                    <span class="help-block">
                    Tulis kota penerbit dengan diawali huruf kapital. Contoh: Jakarta</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
         </div>
      </form>
      {{-- Form end --}}
    </div>    
  </div>
</div>
{{-- Modal end --}}

{{-- Modal start Edit--}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="modalContent">
      <div class="modal-header">
        <button type="button" class="close" 
          data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Data Penerbit</h4>
      </div>
      {{-- Isinya dari getEditForm.blade.php --}}
    </div>
  </div>
</div>
{{-- Modal end edit --}}

<script type="text/javascript">
  function getEditForm(id) {
  $.ajax({
      type:'POST',
      url:'{{route("daftar-penerbit.getEditForm")}}',
      data:{
            '_token': '<?php echo csrf_token() ?>',
            'id':id
          },
      success:function(data) {
          $("#modalContent").html(data.msg);
      }
  });
  }

  function updateData(id)
    {
      var eName=$('#eName').val();
      var eCity =$('#eCity').val();
      $.ajax({
          type:'POST',
          url:'{{route("daftar-penerbit.updateData")}}',
          data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id,
                'name':eName,
                'city':eCity
              },
          success:function(data) {
            $("#modalContent").html(data.msg);
          }
      });
    }
</script>
</body>
</html>



{{-- start ajax --}}
{{-- @section('javascript')
<script type="text/javascript">
    function getEditForm(id) {
    $.ajax({
        type:'POST',
        url:'{{route("daftar-penerbit.getEditForm")}}',
        data:{
              '_token': '',
              'id':id
            },
        success:function(data) {
            $("#modalContent").html(data.msg);
        }
    });
    }
</script>
@endsection --}}
{{-- end ajax --}}
