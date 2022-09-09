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
  <h2>Daftar Penulis</h2>
  <a href="#modalCreate" data-toggle="modal" class="btn btn-info">+ Tambah Data</a>         
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama Penulis</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    @php $no = 1; @endphp
      @foreach ($result as $aut)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{$aut->id}}</td>
            <td>{{$aut->name}}</td>
            <td>
                <a href="{{url ('daftar-penulis/'.$aut->id.'/edit')}}" data-toggle="modal" class="btn btn-warning" onclick="getEditForm({{$aut->id}})">Ubah</a>
                <a class="btn btn-danger" onclick="if(confirm('Apakah anda yakin menghapus data {{$aut->name}}'))">Hapus</a>
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
      <form role="form" method="POST" action="{{url('daftar-penulis')}}">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Penulis</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Penulis</label>
                    <input type="text" class="form-control" placeholder="Isikan nama penerbit" name="name">
                    <span class="help-block">
                    Tulis nama penulis dengan lengkap</span>
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
</body>
</html>