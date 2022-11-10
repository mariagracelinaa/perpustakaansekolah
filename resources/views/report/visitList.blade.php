@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <label>Filter Data Berdasarkan</label><br>
    <select name="filter" id="filter" class="form-control">
        <option value="">-- Pilih Kriteria --</option>
        <option value="date">Tanggal Kunjungan</option>
        <option value="role">Kelas/Jabatan</option>
    </select>
    <br>
    <label>Kelas/Jabatan</label>
    <select name="role" id="role" class="form-control" disabled>
        <option value="">-- Pilih Kelas/Jabatan --</option>
        <option value="guru/staf">Guru/Staf</option>
        @foreach ($class as $c)
            <option value="{{$c->id}}">{{$c->name}}</option>
        @endforeach
    </select>
    <br>
    <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" class="form-control" disabled></label>
    <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end"  class="form-control" disabled></label>
    <input type="button" value="Tampilkan Data" id="btn_show" class="btn btn-primary" onclick="filterData()" disabled>
  </div>
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
                      <tbody id="show_data">
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
  <script>
    // Untuk disable/visible filter
    $("#filter").change(function () {
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

        // reset tgl kalau user sdh pilih tgl tapi mengubah filter ke status
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
    });

    // Untuk ambil dan tampilkan data filter dari controller
    function filterData()
    {
      var start_date = $('#date_start').val();
      var end_date = $('#date_end').val();
      var role = $('#role').val();
      var filter = $('#filter').val();
      $.ajax({
        type:'POST',
        url:'{{url("/laporan-kunjungan-filter")}}',
        data:{
          '_token': '<?php echo csrf_token() ?>',
          'start_date': start_date,
          'end_date' : end_date,
          'role': role,
          'filter' : filter,
        },
        success:function(data) {
          var no = 1;
          var table = $('#custometable').DataTable();
                  
          if(jQuery.isEmptyObject(data.data)){
            // Jika data kosong clear datatablenya
            table.rows().remove().draw();
          }else{
            $('#show_data').html('');
            $.each(data.data, function(key, value) {
              var data = "<tr><td style='width: 5%;'>" + no++ + "</td><td>" + value.name + "</td><td>";
              if(value.class != null){
                data += value.class;
              }else{
                data += "Guru/Staf";
              }

              data += "</td><td>" + value.visit_time + "</td><td>{{$d->description}}</td></tr>";
                          
              $("#show_data").append(data);
            });
          }
        }
      });
    }
  </script>
@endsection