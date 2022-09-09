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
  <h2>Daftar Buku</h2>          
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Judul</th>
        <th>ISBN</th>
        <th>Tahun Terbit</th>
        <th>Tahun Pengadaan</th>
        <th>Kelas DDC</th>
        <th>Klasifikasi</th>
        <th>Edisi</th>
        <th>Jumlah Halaman</th>
        <th>Tinggi Buku (cm)</th>
        <th>Lokasi</th>
        <th>Penerbit</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($result as $biblio)
        <tr>
          <td>{{$biblio->title}}</td>
          <td>{{$biblio->isbn}}</td>
          <td>{{$biblio->publish_year}}</td>
          <td>{{$biblio->purchase_year}}</td>
          <td>{{$biblio->ddc}}</td>
          <td>{{$biblio->classification}}</td>
          <td>{{$biblio->edition}}</td>
          <td>{{$biblio->page}}</td>
          <td>{{$biblio->book_height}}</td>
          <td>{{$biblio->location}}</td>
          <td>{{$biblio->publishers->name}}</td>
          <td><a href="">Ubah</a> <a href="daftar-buku-detail/{{$biblio->id}}">Detail</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

</body>
</html>
