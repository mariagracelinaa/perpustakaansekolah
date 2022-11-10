@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <label>Filter Data Berdasarkan Tanggal Pemesanan</label><br>
    <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" class="form-control"></label>
    <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end"  class="form-control"></label>
    <input type="button" value="Tampilkan Data" id="btn_show" class="btn btn-primary" onclick="filterData()">
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

@section('javascript')
    <script>
      // Untuk ambil dan tampilkan data filter dari controller
      function filterData()
      {
        var start_date = $('#date_start').val();
        var end_date = $('#date_end').val();
        $.ajax({
          type:'POST',
          url:'{{url("/daftar-pemesanan-filter")}}',
          data:{
            '_token': '<?php echo csrf_token() ?>',
            'start_date': start_date,
            'end_date' : end_date,
          },
          success:function(data) {
            var no = 1;
            var table = $('#custometable').DataTable();
                  
            if(jQuery.isEmptyObject(data.data)){
              // Jika data kosong clear datatablenya
              table.rows().remove().draw();
            }else{
              // alert("berhasil");
              $('#show_data').html('');
              $.each(data.data, function(key, value) {
                var data = "<tr><td style='width: 5%;'>"+ no++ +"</td><td>" + value.name + "</td><td>" + value.title +"</td><td>"+ value.booking_date + "</td><td>";

                if (value.description == null){
                  data += "-";
                }else{
                  data += value.description;
                }

                data +=  "</td></tr>";
                          
                $("#show_data").append(data);
              });
            }
          }
        });
      }
    </script>
@endsection