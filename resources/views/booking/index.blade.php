@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <form action="{{url('/daftar-pemesanan-filter')}}">
      <label>Filter Data Berdasarkan</label><br>
      <select name="filter" id="filter" class="form-control">
        @if ($filter == "")
            <option value="" selected>-- Pilih Kriteria --</option>
        @else
            <option value="">-- Pilih Kriteria --</option>
        @endif
          
        @if ($filter == "date")
            <option value="date" selected>Tanggal Pemesanan</option>
        @else
            <option value="date">Tanggal Pemesanan</option>
        @endif
          
        @if ($filter == "status")
            <option value="status" selected>Status</option>
        @else
            <option value="status">Status</option>
        @endif
      </select>
      <br>
      <label>Status Pemesanan</label><br>
      <select name="status" id="status" class="form-control" disabled>
        @if ($status == "")
          <option value="" selected>-- Pilih Status --</option>
        @else
          <option value="">-- Pilih Status --</option> 
        @endif

        @if ($status == "proses")
          <option value="proses" selected>Proses</option>
        @else
          <option value="proses">Proses</option>
        @endif

        @if ($status == "dibatalkan")
          <option value="dibatalkan" selected>Dibatalkan</option>
        @else
          <option value="dibatalkan">Dibatalkan</option>
        @endif
        
        @if ($status == "selesai")
          <option value="selesai" selected>Selesai</option>
        @else
          <option value="selesai">Selesai</option>
        @endif
      </select>
      <br>
      <label>Filter Data Berdasarkan Tanggal Pemesanan</label><br>
      <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" value="{{$start}}" class="form-control" disabled></label>
      <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end" value="{{$end}}" class="form-control" disabled></label>
      <input type="submit" value="Tampilkan Data" id="btn_show" class="btn btn-primary" disabled>
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
                  <th>Status</th>
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
                    @if ($bk->status == "proses")
                      <td style="background-color: rgb(255, 255, 157)">
                        Proses
                      </td>
                    @elseif ($bk->status == "selesai")
                      <td style="background-color: rgb(78, 255, 164)">
                        Selesai
                      </td>
                    @else
                      <td style="background-color: rgb(255, 100, 98)">
                        Dibatalkan
                      </td>
                    @endif
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
      // Untuk disable/visible filter
      $("#filter").change(function () {
          filter();
      });

      $(document).ready(function() {
        filter();
      });

      function filter(){
        if($("#filter").val() == "date"){
              $("#date_start").removeAttr("disabled");
              $("#btn_show").removeAttr("disabled");
              $("#date_end").removeAttr("disabled");
              $("#status").attr('disabled', 'disabled');

              $("#status").val('');
          }else if($("#filter").val() == "status"){
              $("#status").removeAttr("disabled");
              $("#btn_show").removeAttr("disabled");
              $("#date_start").attr('disabled', 'disabled');
              $("#date_end").attr('disabled', 'disabled');

              // reset tgl kalau user sdh pilih tgl tapi mengubah filter ke status
              $("#date_start").val('');
              $("#date_end").val('');
          }else{
              $("#btn_show").attr('disabled', 'disabled');
              $("#date_start").attr('disabled', 'disabled');
              $("#date_end").attr('disabled', 'disabled');
              $("#status").attr('disabled', 'disabled');

              $("#status").val('');
              $("#date_start").val('');
              $("#date_end").val('');
          }
      }
    </script>
@endsection