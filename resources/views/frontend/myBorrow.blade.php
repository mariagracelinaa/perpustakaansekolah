@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Pinjaman Saya</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        {{-- desktop view --}}
                        <div class="col-sm-12 mySuggestDesktop" style="margin-top: 20px">
                          <div class="card-body table-responsive">
                            <table id="custometable" class="table" style="width:100%;border: 0;">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Batas Kembali</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                  @foreach ($data as $d)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{$d->title}}</td>
                                        <td>{{ Carbon\Carbon::parse($d->borrow_date)->format('d F Y') }}</td>
                                        @if( date('Y-m-d') > $d->due_date && $d->status == 'belum kembali')
                                            <td style="background-color: red">
                                                {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}
                                            </td>
                                        @else
                                            <td>
                                                {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}
                                            </td>
                                        @endif
                                        <td>
                                            @if ($d->return_date != null)
                                                {{ Carbon\Carbon::parse($d->return_date)->format('d F Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{$d->fine}}</td>
                                        <td>
                                            @if($d->status == 'sudah kembali')
                                                Sudah Kembali
                                            @elseif($d->status == 'belum kembali')
                                                Belum Kembali
                                            @endif
                                        </td>
                                        <td style="width: 5%;">
                                            <div class="container">
                                            @if ( date('Y-m-d') <= $d->due_date && $d->status == 'belum kembali')
                                              <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a onclick="bookExtensionUser({{$d->id}},'{{$d->register_num}}')" class="btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Perpanjang</a>
                                                    </li>
                                                </ul>
                                              @endif
                                            </div> 
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>

                        {{-- Phone view --}}
                        <div class="col-sm-12 mySuggestPhone" style="margin: 20px">
                            @if(!$data->isEmpty())
                                <div class="card-body table-responsive" >
                                    @foreach ($data as $d)
                                        <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 100%; margin-bottom: 20px">
                                            <div class="card-body">
                                            <h5 class="card-title">{{$d->title}}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                @if($d->status == 'sudah kembali')
                                                    Sudah Kembali
                                                @elseif($d->status == 'belum kembali')
                                                    Belum Kembali
                                                @endif
                                            </h6>
                                            @if ( date('Y-m-d') > $d->due_date && $d->status == 'belum kembali')
                                                <p style="color: red">Tanggal Batas Kembali: {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}</p>
                                            @else
                                                <p>Tanggal Batas Kembali: {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}</p>
                                            @endif

                                            @if ( date('Y-m-d') <= $d->due_date && $d->status == 'belum kembali')
                                                <a onclick="bookExtensionUser({{$d->id}},'{{$d->register_num}}')" class="card-link">Perpanjang</a>
                                            @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h2 style="text-align: center">Tidak Ada data usulan</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    function bookExtensionUser(id, register_num) {
        $.ajax({
            type:'POST',
            url:'{{url("/extension-user")}}',
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