@extends('layouts.gentelella')

@section('content')
<h2>Detail Pengguna</h2>
    <table>
        <tbody>
            <tr>
                <td>Nama </td>
                <td> : {{$user[0]->name}}</td>
            </tr>
            <tr>
                <td>Kelas/Jabatan </td>
                <td> : 
                @if($user[0]->class != null)
                    {{$user[0]->class}}
                @else
                    Guru/Staf
                @endif</td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="container" style="min-height: 100vh"> 
        <div class="row">
          <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Histori Peminjaman</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <a href="/tambah-sirkulasi-buku/{{$user[0]->users_id}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Peminjaman</a>
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
                                <th>Nomor registrasi buku</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Batas Kembali</th>
                                <th>Tanggal Kembali</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($data as $d)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{$d->register_num}}</td>
                                        <td>{{$d->title}}</td>
                                        <td>{{ Carbon\Carbon::parse($d->borrow_date)->format('d-m-Y') }}</td>
                                        @if( date('Y-m-d') > $d->due_date && $d->status == 'belum kembali')
                                            <td style="background-color: red">
                                                {{ Carbon\Carbon::parse($d->due_date)->format('d-m-Y') }}
                                            </td>
                                        @else
                                            <td>
                                                {{ Carbon\Carbon::parse($d->due_date)->format('d-m-Y') }}
                                            </td>
                                        @endif
                                        <td>
                                            @if ($d->return_date != null)
                                                {{ Carbon\Carbon::parse($d->return_date)->format('d-m-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="text-align: right">{{number_format($d->fine)}}</td>
                                        <td>
                                            @if($d->status == 'belum kembali')
                                                Belum Kembali
                                            @elseif($d->status == 'sudah kembali')
                                                Sudah Kembali
                                            @endif
                                        </td>
                                        @if($d->status == 'belum kembali')
                                            <td style="width: 5%;">
                                                <div class="container">
                                                    <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="btn" onclick="bookReturn({{$d->id}},'{{$d->register_num}}')"><i class="bi bi-arrow-return-right" aria-hidden="true"></i> Kembali</a>
                                                        </li>
                                                        @if ( date('Y-m-d') <= $d->due_date )
                                                            <li>
                                                                <a class="btn" onclick="bookExtension({{$d->id}},'{{$d->register_num}}')"><i class="bi bi-file-plus" aria-hidden="true"></i> Perpanjang</a>
                                                            </li>
                                                        @endif
                                                        
                                                    </ul>
                                                </div>
                                            </td>
                                        @else
                                            <td> </td>
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
<script type="text/javascript">
    function bookReturn(id, register_num) {
        $.ajax({
            type:'POST',
            url:'{{url("/return")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'id':id,
                    'reg_num': register_num
                },
            success:function(data) {
                location.reload();
            }
        });
    }

    function bookExtension(id, register_num) {
        $.ajax({
            type:'POST',
            url:'{{url("/extension")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'id':id,
                    'reg_num': register_num
                },
            success:function(data) {
                location.reload();
            }
        });
    }
</script>
@endsection