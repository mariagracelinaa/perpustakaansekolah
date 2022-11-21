@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px; width: 70%; justify-content: center;"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Daftar Pesanan Saya</small></h2>
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
                                    <th>Tanggal Pesan</th>
                                    <th>Alasan Pesan</th>
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
                                        <td>{{ Carbon\Carbon::parse($d->booking_date)->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            @if ($d->description != NULL)
                                                {{$d->description}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @if ($d->status == "proses")
                                            <td style="background-color: rgb(255, 255, 157)">
                                                Proses
                                            </td>
                                        @elseif ($d->status == "selesai")
                                            <td style="background-color: rgb(78, 255, 164)">
                                                Selesai
                                            </td>
                                        @else
                                            <td style="background-color: rgb(255, 100, 98)">
                                                Dibatalkan
                                            </td>
                                        @endif
                                        <td style="width: 2%;">
                                            <div class="container" style="color: white; ">
                                                <a onclick="deleteMyBooking({{Auth::user()->id}},'{{$d->id}}','{{$d->bid}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true" style="height: 20px;"></i></a>
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
                                <div class="card-body table-responsive" >
                                    @foreach ($data as $d)
                                        <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 100%; margin-bottom: 20px">
                                            <div class="card-body">
                                            <h5 class="card-title">{{$d->title}}</h5>
                                            <p>{{ Carbon\Carbon::parse($d->booking_date)->isoFormat('D MMMM Y') }}</p>
                                            @if ($d->status == "proses")
                                                <p style="background-color: rgb(255, 255, 157)">
                                                    Status : Proses
                                                </p>
                                            @elseif ($d->status == "selesai")
                                                <p style="background-color: rgb(78, 255, 164)">
                                                    Status : Selesai
                                                </td>
                                            @else
                                                <p style="background-color: rgb(255, 100, 98)">
                                                    Status : Dibatalkan
                                                </p>
                                            @endif
                                            <a onclick="deleteMyBooking({{Auth::user()->id}},'{{$d->id}}','{{$d->bid}}')" class="card-link text-danger">Batalkan</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h2 style="text-align: center">Tidak Ada data pesanan</h2>
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
    function deleteMyBooking(id, biblios_id,bookings_id) {
        $.ajax({
            type:'POST',
            url:'{{url("/hapus-pesanan")}}',
            data:{
                    '_token': '<?php echo csrf_token() ?>',
                    'id':id,
                    'biblios_id': biblios_id,
                    'bookings_id': bookings_id,
                },
            success:function(data) {
                location.reload();
            }
        });
    }
</script>
@endsection