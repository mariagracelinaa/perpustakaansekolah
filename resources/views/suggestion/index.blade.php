@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
    <div>
        <label>Filter Data Berdasarkan</label><br>
        <select name="filter" id="filter" class="form-control">
            <option value="">-- Pilih Kriteria --</option>
            <option value="date">Tanggal Usulan</option>
            <option value="status">Status</option>
        </select>
        <br>
        <label>Status Buku Usulan</label>
        <select name="status" id="status" class="form-control" disabled>
            <option value="">-- Pilih Status --</option>
            <option value="proses review">Proses Review</option>
            <option value="ditolak">Ditolak</option>
            <option value="diterima">Diterima</option>
            <option value="selesai">Selesai</option>
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
                    <h2>Daftar Usulan Buku</small></h2>
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
                                    <th>Nama Pengusul</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tanggal Usulan</th>
                                    <th>Alasan Mengusulkan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                @php $no = 1; @endphp
                                @foreach ($data as $u)
                                <tr>
                                    <td style="width: 5%;">{{ $no++ }}</td>
                                    <td>{{$u->users->name}}</td>
                                    <td>{{$u->title}}</td>
                                    <td>{{$u->author}}</td>
                                    <td>{{$u->publisher}}</td>
                                    <td>{{ Carbon\Carbon::parse($u->date)->format('d-m-Y') }}</td>
                                    <td>
                                        @if($u->description == null)
                                            -
                                        @else
                                            {{$u->description}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->status == 'proses review')
                                            Proses Review
                                        @elseif($u->status == 'ditolak')
                                            Ditolak
                                        @elseif($u->status == 'diterima')
                                            Diterima
                                        @else
                                            Selesai
                                        @endif
                                    </td>
                                    <td style="width: 5%;">
                                        <div class="container">
                                            <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#modalEdit" data-toggle="modal" class="btn" onclick="getEditForm({{$u->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                                                <li>
                                                    <a class="btn" onclick="if(confirm('Apakah anda yakin menghapus data usulan {{$u->title}}'))
                                                        deleteDataRemoveTR({{$u->id}})"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                                                </li>
                                            </ul>
                                        </div> 
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
    {{-- Modal start Add--}}
    <div class="modal fade" id="modalPrint" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" >
            {{-- Form start --}}
            <form role="form" target="_blank" method="GET" action="{{url('/cetak-usulan')}}">
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
    {{-- Modal start Edit--}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
            <div class="modal-header">
            <button type="button" class="close" 
                    data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Ubah Data Penerbit</h4>
            </div>
            {{-- Isinya dari getEditForm.blade.php --}}
        </div>
        </div>
    </div>
    {{-- Modal end edit --}}
@endsection

@section('javascript')
  <script type="text/javascript">
    function getEditForm(id) {
    $.ajax({
        type:'POST',
        url:'{{route("daftar-usulan-buku.getEditForm")}}',
        data:{
              '_token': '<?php echo csrf_token() ?>',
              'id':id
            },
        success:function(data) {
            $("#modalContent").html(data.msg);
        }
    });
    }

    function updateData(id)
    {
        var eStatus=$('#eStatus').val();
        $.ajax({
            type:'POST',
            url:'{{route("daftar-usulan-buku.updateData")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'id':id,
                    'status':eStatus,
                },
            success:function(data) {
                location.reload();
            }
        });
    }

    function deleteDataRemoveTR(id){
        $.ajax({
            type:'POST',
            url:'{{route("suggestions.deleteDataAdmin")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'id':id
                },
            success:function(data) {
                location.reload(); 
            }
        });
    }

    // Untuk disable/visible filter
    $("#filter").change(function () {
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
    });

    // Untuk ambil dan tampilkan data filter dari controller
    function filterData()
    {
        var start_date = $('#date_start').val();
        var end_date = $('#date_end').val();
        var status = $('#status').val();
        var filter = $('#filter').val();
        $.ajax({
            type:'POST',
            url:'{{url("/daftar-usulan-buku-filter")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'start_date': start_date,
                    'end_date' : end_date,
                    'status': status,
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
                        var data = "<tr><td style='width: 5%;'>"+ no++ +"</td><td>"+ value.name +"</td><td>"+value.title+"</td><td>"+value.author+"</td><td>"+value.publisher+"</td><td>"+value.date+"</td><td>";

                        if (value.description == null){
                            data += "-";
                        }else{
                            data += value.description;
                        }

                        data += "</td><td>";

                        if(value.status == "proses review"){
                            data += "Proses Review";
                        }else if(value.status == "ditolak"){
                            data += "Ditolak";
                        }else if(value.status == 'diterima'){
                            data += "Diterima";
                        }else{
                            data += "Selesai";    
                        }

                        data += "</td><td style='width: 5%;'><div class='container'><a class='btn' data-toggle='dropdown'><i class='fa fa-ellipsis-v' aria-hidden='true'></i></a><ul class='dropdown-menu'><li><a href='#modalEdit' data-toggle='modal' class='btn' onclick='getEditForm(";
                        
                        data += value.id;
                        data += ")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah</a></li><li><a class='btn' onclick='if(confirm('Apakah anda yakin menghapus data usulan ";
                        data += value.title;
                        data += "')) deleteDataRemoveTR(";
                        data += value.id;
                        data += ")'><i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a></li></ul></div></td></tr>";

                        // table.rows.add(data).draw();
                        $("#show_data").append(data);
                    });
                }
            }
        });
    }
  </script>
@endsection