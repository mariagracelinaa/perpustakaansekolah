@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="text-align: center">
                    <h2>Daftar Buku</small></h2>
                    <div>
                        <input type="text" class="icon" style="width:200px; height:30px" placeholder="Cari Buku" >
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        {{-- desktop view --}}
                        <div class="col-sm-12 mySuggestDesktop" style="margin-top: 20px;">
                            <div class="card-body table-responsive">
                                <table id="custometable" class="table" style="border: 1px;">
                                    <thead>
                                        <th>Cover</th>
                                        <th>Informasi Buku</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:150px; height:200px"><img src="{{asset('images/testbook.jpg')}}" width="100%"></td>
                                            <td>
                                                <p>xxxx</p><br>
                                                <p>xxxx</p><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:150px; height:200px"><img src="{{asset('images/testbook.jpg')}}" width="100%"></td>
                                            <td>
                                                <p>xxxx</p><br>
                                                <p>xxxx</p><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:150px; height:200px"><img src="{{asset('images/testbook.jpg')}}" width="100%"></td>
                                            <td>
                                                <p>xxxx</p><br>
                                                <p>xxxx</p><br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Phone view --}}
                        {{-- <div class="col-sm-12 mySuggestPhone" style="margin: 20px">
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
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@endsection