@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Pengunjung Perpustakaan</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <button href="#modalPrint" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Data</button>  
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
                          <th>Nama</th>
                          <th>Kelas/Jabatan</th>
                          <th>Tanggal Kunjugan</th>
                          <th>Keperluan</th>
                        </tr>
                      </thead>
                      <tbody>
                      @php $no = 1; @endphp
                        @foreach ($data as $d)
                          <tr>
                            <td style="width: 5%;">{{ $no++ }}</td>
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
                            <td>{{ Carbon\Carbon::parse($d->visit_time)->format('d-m-Y') }}</td>
                            <td>{{$d->description}}</td>
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

{{-- Modal start Add--}}
<div class="modal fade" id="modalPrint" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" >
        {{-- Form start --}}
        <form role="form" target="_blank" method="GET" action="{{url('/cetak-laporan-kunjungan')}}">
        <div class="modal-header">
            <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title ">Cetak Data</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" required class="form-control" name="start_date" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" required class="form-control" name="end_date" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-info">Cetak</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        </div>
        </form>
        {{-- Form end --}}
    </div>    
  </div>
</div>
{{-- Modal end --}}
@endsection

@section('javascript')
@endsection