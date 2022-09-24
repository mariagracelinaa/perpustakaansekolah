@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Laporan Penghapusan Buku</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              {{-- Bisa diisi print --}}
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
                    <td>{{$del->deletion_date}}</td>
                    <td>{{$del->description}}</td>
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
@endsection