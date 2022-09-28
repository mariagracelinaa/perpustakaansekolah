@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Pemesanan Buku</small></h2>
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
                  <th>Nama Pemesan</th>
                  <th>Judul Buku</th>
                  <th>Tanggal Pemesanan</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($data as $bk)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$bk->name}}</td>
                    <td>{{$bk->title}}</td>
                    <td>{{$bk->booking_date}}</td>
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