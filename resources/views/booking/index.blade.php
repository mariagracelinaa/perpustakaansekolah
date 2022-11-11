@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <form action="{{url('/daftar-pemesanan-filter')}}">
      <label>Filter Data Berdasarkan Tanggal Pemesanan</label><br>
      <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" value="{{$start}}" class="form-control"></label>
      <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end" value="{{$end}}" class="form-control"></label>
      <input type="submit" value="Tampilkan Data" id="btn_show" class="btn btn-primary">
    </form>
  </div>
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
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody id="show_data">
              @php $no = 1; @endphp
                @foreach ($data as $bk)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$bk->name}}</td>
                    <td>{{$bk->title}}</td>
                    <td>{{ Carbon\Carbon::parse($bk->booking_date)->format('d-m-Y') }}</td>
                    <td>
                      @if ($bk->description == null)
                          -
                      @else
                          {{$bk->description}}
                      @endif
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