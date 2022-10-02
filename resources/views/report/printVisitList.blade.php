<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Cetak Daftar Kunjungan Perpustakaan</title>
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
                                    LAPORAN KUNJUNGAN PERPUSTAKAAN
                                </p>
                                <p align="center" style="line-height: 1.5; font-weight: bold;">
                                    PERPUSTAKAAN SMA KATOLIK SANTO CAROLUS SURABAYA
                                </p>
                                <p align="center">
                                    Periode Tanggal Kunjungan {{$start}} s/d {{$end}}
                                </p>
                            </div> 
                        </div>
                    <hr/>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Kelas/Jabatan</th>
                              <th>Tanggal Kunjugan</th>
                              <th>Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data as $d)
                            <tr>
                                <td style="width: 5%;">{{ $no++ }}</td>
                                <td>
                                    {{$d->name}}
                                </td>
                                <td>
                                    @if($d->class != null)
                                        {{$d->class}}
                                    @else
                                        Guru/Staf
                                    @endif
                                </td>
                                <td>{{$d->visit_time}}</td>
                                <td>{{$d->description}}</td>
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