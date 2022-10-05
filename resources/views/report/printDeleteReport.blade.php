<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Cetak Laporan Penghapusan Buku</title>
</head>

<style>
    .line-title{
        border: 0;
        border-style: inset;
        border-top: 1px solid #000;
    }

    tr, td {
        text-align: center;
    }
</style>
<body style="background-color: white;" onload="window.print()">
    <div class="row">
        <div class="col-md-12">
            
                <table style="width: 100%; padding: 50px;">
                    <hr class="line-title">
                        <div>
                            <div style="float: left; margin-left: 50px">
                                <img src="https://sma-carolus-sby.tarakanita.sch.id/images/default/tarakanita.png" alt="" height="120px">
                            </div>
                            <div style="width:80%">
                                <p align="center">
                                    LAPORAN PENGHAPUSAN BUKU
                                </p>
                                <p align="center" style="line-height: 1.5; font-weight: bold;">
                                    PERPUSTAKAAN SMA KATOLIK SANTO CAROLUS SURABAYA
                                </p>
                                <p align="center">
                                    Periode Tanggal Penghapusan {{$start}} s/d {{$end}}
                                </p>
                            </div> 
                        </div>
                    <hr/>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Register</th>
                                <th>Judul Buku</th>
                                <th>Sumber Buku</th>
                                <th>Harga</th>
                                <th>Tanggal Penghapusan</th>
                                <th>Deskripsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php $no = 1; $i = 0 @endphp
                            @foreach ($data as $del)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{$del->register_num}}</td>
                                    <td>{{$del->title}}</td>
                                    <td>
                                        @if($del->source == 'pembelian')
                                        Pembelian
                                        @else
                                        Hadiah
                                        @endif
                                    </td>
                                    <td style="text-align: right">{{number_format($del->price)}}</td>
                                    <td>{{ Carbon\Carbon::parse($del->delete_date)->format('d-m-Y') }}</td>
                                    <td>{{$del->delete_description}}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                          </tbody>
                    </table>
                </table>
                <div style="text-align: right; margin-right: 50px">
                    <p>
                        Surabaya, {{ $today }}
                    </p>
                </div>
        </div>
    </div>
</body>
</html>