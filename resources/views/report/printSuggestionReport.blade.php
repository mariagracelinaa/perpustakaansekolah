<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Cetak Daftar Usulan Buku</title>
</head>

<style>
    .line-title{
        border: 0;
        border-style: inset;
        border-top: 1px solid #000;
    }

    th {
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
                                    LAPORAN USULAN BUKU
                                </p>
                                <p align="center" style="line-height: 1.5; font-weight: bold;">
                                    PERPUSTAKAAN SMA KATOLIK SANTO CAROLUS SURABAYA
                                </p>
                                <p align="center">
                                    Periode Tanggal Usulan {{$start}} s/d {{$end}}
                                </p>
                            </div> 
                        </div>
                    <hr/>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengusul</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tanggal Usulan</th>
                                <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php $no = 1; $i = 0 @endphp
                            @foreach ($data as $u)
                                <tr>
                                    <td style="width: 5%;">{{ $no++ }}</td>
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->title}}</td>
                                    <td>{{$u->author}}</td>
                                    <td>{{$u->publisher}}</td>
                                    <td>{{$u->date}}</td>
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
                                </tr>
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