@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <form action="{{url('/statistik-peminjam-filter')}}">
      <label>Filter Data Berdasarkan</label><br>
      <select name="filter" id="filter" class="form-control">
        @if ($filter == "")
            <option value="" selected>-- Pilih Kriteria --</option>
        @else
            <option value="">-- Pilih Kriteria --</option>
        @endif

        @if ($filter == "role")
            <option value="role" selected>Peran</option>
        @else
            <option value="role">Peran</option>
        @endif
          
        @if ($filter == "date")
            <option value="date" selected>Tanggal Pinjaman</option>
        @else
            <option value="date">Tanggal Pinjaman</option>
        @endif
        
        @if ($filter == "allCriteria")
            <option value="allCriteria" selected>Peran dan Tanggal</option>
        @else
            <option value="allCriteria">Peran dan Tanggal</option>
        @endif
      </select>
      <br>
      <label>Peran Pengguna</label><br>
      <select name="role" id="role" class="form-control" disabled>
        @if ($role == "")
          <option value="" selected>-- Pilih Peran --</option>
        @else
          <option value="">-- Pilih Peran --</option> 
        @endif

        @if ($role == "guru/staf")
          <option value="guru/staf" selected>Guru/Staf</option>
        @else
          <option value="guru/staf">Guru/Staf</option>
        @endif

        @if ($role == "murid")
          <option value="murid" selected>Murid</option>
        @else
          <option value="murid">Murid</option>
        @endif
      </select>
      <br>
      <label>Filter Data Berdasarkan Tanggal Pinjaman</label><br>
      <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" value="{{$start}}" class="form-control" disabled></label>
      <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end" value="{{$end}}" class="form-control" disabled></label>
      <input type="submit" value="Tampilkan Data" id="btn_show" class="btn btn-primary" disabled>
    </form>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Pengguna Paling Banyak Pinjam</small></h2>
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
                  <th>Nama Pengguna</th>
                  <th>Kelas/Jabatan</th>
                  <th>Banyak Pinjaman</th>
                </tr>
              </thead>
              <tbody id="show_data">
              @php $no = 1; @endphp
                @foreach ($data as $bk)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$bk->name}}</td>
                    <td>
                        @if ($bk->class == null)
                            Guru/Staf
                        @else
                            {{$bk->class}}
                        @endif
                    </td>
                    <td>{{ $bk->count }}</td>
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
              $("#role").attr('disabled', 'disabled');

              $("#role").val('');
          }else if($("#filter").val() == "role"){
              $("#role").removeAttr("disabled");
              $("#btn_show").removeAttr("disabled");
              $("#date_start").attr('disabled', 'disabled');
              $("#date_end").attr('disabled', 'disabled');

              // reset tgl kalau user sdh pilih tgl tapi mengubah filter ke role
              $("#date_start").val('');
              $("#date_end").val('');
          }else if($("#filter").val() == "allCriteria"){
              $("#role").removeAttr("disabled");
              $("#btn_show").removeAttr("disabled");
              $("#date_start").removeAttr("disabled");
              $("#date_end").removeAttr("disabled");

              $("#date_start").val('');
              $("#date_end").val('');
          }else{
              $("#btn_show").attr('disabled', 'disabled');
              $("#date_start").attr('disabled', 'disabled');
              $("#date_end").attr('disabled', 'disabled');
              $("#role").attr('disabled', 'disabled');

              $("#role").val('');
              $("#date_start").val('');
              $("#date_end").val('');
          }
      }
    </script>
@endsection