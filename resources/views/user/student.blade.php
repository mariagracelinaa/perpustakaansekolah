@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Murid</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                {{-- Tambah data ke halaman register --}}
              <a href="{{route('register')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>    
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                  <div class="col-sm-12">
                    <div class="card-box table-responsive">
            <table id="custometable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor NISN</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($data as $std)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$std->nisn}}</td>
                    <td>{{$std->name}}</td>
                    <td>{{$std->class}}</td>
                    <td>{{$std->email}}</td>
                    <td style="width: 5%;">
                        <div class="container">
                            <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                  <a href="{{url('/ubah-data-pengguna/'.$std->id)}}" class="btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                                <li>
                                <a class="btn" onclick="if(confirm('Apakah anda yakin menghapus data {{$std->name}}'))"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                                </li>
                            </ul>
                        </div> 
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script>
 
</script>
@endsection