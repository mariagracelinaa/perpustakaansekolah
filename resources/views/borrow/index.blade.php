@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Peminjaman Buku</small></h2>
            {{-- <ul class="nav navbar-right panel_toolbox">
              <button href="#modalCreate" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>    
            </ul> --}}
          <div class="clearfix"></div>
          </div>
          <div class="x_content">
            {{-- <div style="text-align: right">
                <label>Tanggal Mulai</label>
                <input type="date" id="start">
                <label>Tanggal Selesai</label>
                <input type="date" id="end">
                <a class="btn btn-outline-dark" onclick="filter()">Filter</a>
            </div> --}}
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
</script>
@endsection