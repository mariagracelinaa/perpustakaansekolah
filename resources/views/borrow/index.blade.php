@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <form action="{{url('/daftar-peminjaman-filter')}}">
      <label>Filter Data Berdasarkan</label><br>
      <select name="filter" id="filter" class="form-control">
        @if ($filter == "")
            <option value="" selected>-- Pilih Kriteria --</option>
        @else
            <option value="">-- Pilih Kriteria --</option>
        @endif

        @if ($filter == "active_borrow")
            <option value="active_borrow" selected>Peminjaman Aktif</option>
        @else
            <option value="active_borrow">Peminjaman Aktif</option>
        @endif
        
        @if ($filter == "complete_borrow")
            <option value="complete_borrow" selected>Peminjaman Selesai</option>
        @else
            <option value="complete_borrow">Peminjaman Selesai</option>
        @endif

        @if ($filter == "date_borrow")
            <option value="date_borrow" selected>Tanggal Pinjam</option>
        @else
            <option value="date_borrow">Tanggal Pinjam</option>
        @endif
        
        @if ($filter == "due_date")
            <option value="due_date" selected>Tanggal Kembali</option>
        @else
            <option value="due_date">Tanggal Kembali</option>
        @endif
      </select>
      <br>
      <label>Filter Data Berdasarkan Tanggal</label><br>
      <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" value="{{$start}}" class="form-control" disabled></label>
      <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" value="{{$end}}" id="date_end" class="form-control" disabled></label>
      <input type="submit" value="Tampilkan Data" id="btn_show" class="btn btn-primary">
    </form>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Peminjaman Buku</small></h2>
          <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br>
            <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
                    <table id="custometable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Peminjaman</th>
                          <th>Tanggal Pinjam</th>
                          <th>Tanggal Batas Kembali</th>
                          <th>Total Denda</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @php $no = 1; @endphp
                        @foreach ($result as $br)
                          <tr>
                            <td style="width: 5%;">{{ $no++ }}</td>
                            <td>{{$br->name}}</td>
                            <td>
                              {{ Carbon\Carbon::parse($br->borrow_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ Carbon\Carbon::parse($br->due_date)->format('d-m-Y') }}</td>
                            <td style="text-align: right">{{number_format($br->total_fine)}}</td>
                            <td style="width: 10%;">
                              <a href="#modalDetail" data-toggle="modal" class="btn btn-info" onclick="getDetail({{$br->id}})"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</a> 
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

{{-- Modal start detail--}}
<div class="modal fade" id="modalDetail" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="modalContent">
      <div class="modal-header">
      <button type="button" class="close" 
          data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Detail Transaksi Peminjaman</h4>
      </div>
      {{-- Isinya dari getDetailBorrowTransaction.blade.php --}}
  </div>
  </div>
</div>
{{-- Modal end detail --}}
@endsection

@section('javascript')
<script>
  function getDetail(id) {
    $.ajax({
        type:'POST',
        url:'{{route("daftar-peminjaman.getDetail")}}',
        data:{
              '_token': '<?php echo csrf_token() ?>',
              'id':id
            },
        success:function(data) {
            $("#modalContent").html(data.msg);
        }
    });
  }

  $( document ).ready(function() {
    filter();
  });

  // Untuk disable/visible filter
  $("#filter").change(function () {
    filter();
  });

  function filter(){
    if($("#filter").val() == "date_borrow" || $("#filter").val() == "due_date"){
      $("#date_start").removeAttr("disabled");
      $("#btn_show").removeAttr("disabled");
      $("#date_end").removeAttr("disabled");
    }else if($("#filter").val() == "active_borrow" || $("#filter").val() == "complete_borrow"){
      $("#date_start").attr('disabled', 'disabled');
      $("#date_end").attr('disabled', 'disabled');
      $("#btn_show").removeAttr("disabled");

      $("#date_start").val('');
      $("#date_end").val('');
    }else{
      $("#btn_show").attr('disabled', 'disabled');
      $("#date_start").attr('disabled', 'disabled');
      $("#date_end").attr('disabled', 'disabled');

      $("#date_start").val('');
      $("#date_end").val('');
    }
  }
</script>
@endsection