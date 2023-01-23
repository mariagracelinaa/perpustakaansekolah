@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px; width: 70%; justify-content: center;"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Penulis</small></h2>
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
                                    <th>Nama Penulis</th>
                                    {{-- <th>Jumlah Koleksi</th> --}}
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                  @foreach ($author as $au)
                                    <tr>
                                        <td style="width: 5%;">{{ $no++ }}</td>
                                        <td>{{$au->name}}</td>
                                        {{-- <td>{{$d[$no-1][0]->jumlah_koleksi}}</td> --}}
                                        <td>
                                            <a href="{{url('/buku-penulis/'.$au->id)}}" class="btn btn-warning"><i class="fa fa-info" aria-hidden="true" style="height: 20px;"></i></a>
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
    </div>
</div>
@endsection