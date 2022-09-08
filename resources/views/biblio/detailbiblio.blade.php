<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Detail Buku</h2>
    <table>
        <tbody>
            <tr>
                <td>Judul </td>
                <td>: {{$data->title}}</td>
            </tr>
            <tr>
                <td>ISBN </td>
                <td>: {{$data->isbn}}</td>
            </tr>
            <tr>
                <td>Penerbit </td>
                <td>: {{$data->publishers->name}}</td>
            </tr>
            <tr>
                <td>Tahun terbit </td>
                <td>: {{$data->publish_year}}</td>
            </tr>
            <tr>
                <td>Tahun pengadaan </td>
                <td>: {{$data->purchase_year}}</td>
            </tr>
            <tr>
                <td>Kelas DDC </td>
                <td>: {{$data->ddc}}</td>
            </tr>
            <tr>
                <td>Klasifikasi </td>
                <td>: {{$data->classification}}</td>
            </tr>
            <tr>
                <td>Edisi </td>
                <td>: {{$data->edition}}</td>
            </tr>
            <tr>
                <td>Jumlah halaman </td>
                <td>: {{$data->page}}</td>
            </tr>
            <tr>
                <td>Tinggi buku </td>
                <td>: {{$data->book_height}} cm</td>
            </tr>
            <tr>
                <td>Lokasi buku </td>
                <td>: {{$data->location}}</td>
            </tr>
        </tbody>
    </table>    
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nomor registrasi buku</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$item->register_num}}</td>
                    @if($item->status == "tersedia")
                        <td style="background-color: rgb(113, 255, 113)">
                            Tersedia
                        </td>
                    @else
                        <td style="background-color: rgb(255, 64, 64)">
                            Sedang Dipinjam
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
  </table>
</div>

</body>
</html>
