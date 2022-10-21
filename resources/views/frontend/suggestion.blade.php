@extends('layouts.front')

@section('content')
<div class="container" style="margin-top: 50px"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Semua Usulan Buku</small></h2>
                    <div class="nav navbar-right panel_toolbox">
                        <a href="/usulan-saya/{{Auth::User()->id}}" class="btn btn-light"><i class="fa fa-info-circle"></i> Usulan Saya</a>
                    </div>
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
                                    <th>Nama Pengusul</th>
                                    <th>Judul Buku</th>
                                    <th>Nama Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tanggal Usulan</th>
                                    <th>Status Usulan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                  @foreach ($data as $d)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{$d->users->name}}</td>
                                        <td>{{$d->title}}</td>
                                        <td>{{$d->author}}</td>
                                        <td>{{$d->publisher}}</td>
                                        <td>{{ Carbon\Carbon::parse($d->date)->format('d F Y') }}</td>
                                        <td>
                                            @if($d->status == 'proses review')
                                                Proses Review
                                            @elseif($d->status == 'ditolak')
                                                Ditolak
                                            @elseif($d->status == 'diterima')
                                                Diterima
                                            @else
                                                Selesai
                                            @endif
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
                                <div class="card-body table-responsive">
                                    @foreach ($data as $d)
                                        <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 100%; margin-bottom: 20px">
                                            <div class="card-body">
                                                <h5 class="card-title">{{$d->title}}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    @if($d->status == 'proses review')
                                                        Proses Review
                                                    @elseif($d->status == 'ditolak')
                                                        Ditolak
                                                    @elseif($d->status == 'diterima')
                                                        Diterima
                                                    @else
                                                        Selesai
                                                    @endif
                                                </h6>
                                                <p class=" mb-2">Nama Pengusul: {{$d->users->name}}</p>
                                                <p class=" mb-2">Tanggal Pengusulan: {{ Carbon\Carbon::parse($d->date)->format('d F Y') }}</p>
                                                <p class=" mb-2">Nama Penulis: {{$d->author}}</p>
                                                <p class=" mb-2">Penerbit: {{$d->publisher}}</p>
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