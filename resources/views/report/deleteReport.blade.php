@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <label>Filter Data Berdasarkan</label><br>
    <select name="filter" id="filter" class="form-control">
        <option value="">-- Pilih Kriteria --</option>
        <option value="date">Tanggal Penghapusan</option>
        <option value="source">Sumber</option>
    </select>
    <br>
    <label>Sumber Buku</label>
    <select name="source" id="source" class="form-control" disabled>
        <option value="">-- Pilih Sumber Buku --</option>
        <option value="hadiah">Hadiah</option>
        <option value="pembelian">Pembelian</option>
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
              <tbody id="show_data">
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

@section('javascript')
    <script>
      // Untuk disable/visible filter
      $("#filter").change(function () {
          if($("#filter").val() == "date"){
              $("#date_start").removeAttr("disabled");
              $("#btn_show").removeAttr("disabled");
              $("#date_end").removeAttr("disabled");
              $("#source").attr('disabled', 'disabled');

              $("#source").val('');
          }else if($("#filter").val() == "source"){
              $("#source").removeAttr("disabled");
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
              $("#source").attr('disabled', 'disabled');

              $("#source").val('');
              $("#date_start").val('');
              $("#date_end").val('');
          }
      });

      // Untuk ambil dan tampilkan data filter dari controller
      function filterData()
      {
          var start_date = $('#date_start').val();
          var end_date = $('#date_end').val();
          var source = $('#source').val();
          var filter = $('#filter').val();
          $.ajax({
              type:'POST',
              url:'{{url("/daftar-penghapusan-filter")}}',
              data:{
                      '_token': '<?php echo csrf_token() ?>',
                      'start_date': start_date,
                      'end_date' : end_date,
                      'source': source,
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
                        var data = "<tr><td>"+ no++ +"</td><td>" + value.register_num + "</td><td>{{$del->title}}</td><td>";

                        if(value.source == 'pembelian')
                            data += "Pembelian";
                        else
                            data += "Hadiah";
                    
                        data += "</td><td style='text-align: right'>"+ value.price + "</td><td>"+ value.delete_date +"</td><td>{{$del->delete_description}}</td></tr>";
                          
                        $("#show_data").append(data);
                      });
                  }
              }
          });
      }
    </script>
@endsection