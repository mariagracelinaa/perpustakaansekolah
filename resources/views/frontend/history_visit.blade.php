@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px; width: 70%; justify-content: center;"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Kunjungan Saya</small></h2>
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
                                    <th>Tanggal Kunjungan</th>
                                    <th>Keterangan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                  @foreach ($data as $d)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{ Carbon\Carbon::parse($d->visit_time)->isoFormat('D MMMM Y') }}</td>
                                        <td>{{$d->description}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>

                        {{-- Phone view --}}
                        <div class="col-sm-12 displayPhone" style="margin: 20px">
                            @if(!$data->isEmpty())
                                <div class="card-body table-responsive" >
                                    @foreach ($data as $d)
                                        <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 100%; margin-bottom: 20px">
                                            <div class="card-body">
                                            <h5 class="card-title">{{$d->description}}</h5>
                                            <p>Tanggal Kunjungan: {{ Carbon\Carbon::parse($d->visit_time)->isoFormat('D MMMM Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h2 style="text-align: center">Tidak Ada Data Kunjungan</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection