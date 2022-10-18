@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Laporan Penghapusan Buku</small></h2>
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
                  <th>Nomor Register</th>
                  <th>Judul Buku</th>
                  <th>Sumber Buku</th>
                  <th>Harga</th>
                  <th>Tanggal Penghapusan</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; $i = 0 @endphp
                @foreach ($data as $del)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$del->register_num}}</td>
                    <td>{{$del->title}}</td>
                    <td>
                        @if($del->source == 'pembelian')
                            Pembelian
                        @else
                            Hadiah
                        @endif
                    </td>
                    <td style="text-align: right">{{number_format($del->price)}}</td>
                    <td>{{ Carbon\Carbon::parse($del->delete_date)->format('d-m-Y') }}</td>
                    <td>{{$del->delete_description}}</td>
                  </tr>
                  @php
                      $i++;
                  @endphp
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
        <form role="form" target="_blank" method="GET" action="{{url('/cetak-laporan-penghapusan')}}">
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