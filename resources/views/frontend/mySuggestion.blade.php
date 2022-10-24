@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px; width: 70%; justify-content: center;"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Usulan Buku Saya</small></h2>
                    <div class="nav navbar-right panel_toolbox">
                        <a href="/form-usulan" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Usulan</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        {{-- desktop view --}}
                        <div class="col-sm-12 displayDesktop" style="margin-top: 20px">
                          <div class="card-body table-responsive">
                            <table id="custometable" class="table" style="width:100%;border: 0;">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Nama Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tanggal Usulan</th>
                                    <th>Status Usulan</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                  @foreach ($data as $d)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{$d->title}}</td>
                                        <td>{{$d->author}}</td>
                                        <td>{{$d->publisher}}</td>
                                        <td>{{ Carbon\Carbon::parse($d->date)->isoFormat('D MMMM Y') }}</td>
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
                                        <td style="width: 5%;">
                                            <div class="container">
                                            @if ($d->status != "diterima")
                                              <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="/ubah-usulan/{{$d->id}}" class="btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                                                    <li>
                                                        <a class="btn" href="/hapus-usulan/{{$d->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
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
                        <div class="col-sm-12 displayPhone" style="margin: 20px">
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
                                            <p>Tanggal Pengusulan: {{ Carbon\Carbon::parse($d->date)->isoFormat('D MMMM Y') }}</p>
                                            <a href="/ubah-usulan/{{$d->id}}" class="card-link">Ubah</a>
                                            <a href="/hapus-usulan/{{$d->id}}" class="card-link">Hapus</a>
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