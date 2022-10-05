@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sirkulasi Buku Perpustakaan - Daftar Pengguna Perpustakaan</small></h2>
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
                  <th>NISN/NIY</th>
                  <th>Nama</th>
                  <th>Kelas/Jabatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($data as $d)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>
                        @if($d->role = 'murid')
                            {{$d->nisn}}
                        @endif
                        
                        @if($d->role = 'guru/staf')
                            {{$d->niy}}
                        @endif
                    </td>
                    <td>
                        {{$d->name}}
                    </td>
                    <td>
                        @if($d->class != null)
                            {{$d->class}}
                        @else
                            Guru/Staf
                        @endif
                    </td>
                    <td style="width: 10%;">
                        <ul class="nav navbar-right panel_toolbox">
                          <a class="btn btn-primary" href="sirkulasi-detail/{{$d->id}}"><i class="fa fa-info-circle"></i> Detail</a>    
                        </ul>
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