<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
    {{-- Alert start --}}
    @if(session('status'))  
        <div class="alert alert-success">
            <strong>Sukses!</strong> {{session('status')}}
        </div>
        @elseif(session('error')) 
        <div class="alert alert-danger">
            <strong>Gagal!</strong> {{session('error')}}
        </div>
    @endif
    {{-- Alert End --}}
    <h2>Detail Buku</h2>
    <table>
        <tbody>
            <tr>
                <td>
                    <img src= "{{asset('images/'.$data->image)}}" height="150px">
                </td>
            </tr>
            <tr>
                <td>Judul </td>
                <td> : {{$data->title}}</td>
            </tr>
            <tr>
                <td>ISBN </td>
                <td> : {{$data->isbn}}</td>
            </tr>
            <tr>
                <td>Penerbit </td>
                <td> : {{$data->publishers->name}}</td>
            </tr>
            <tr>
                <td>Kota Terbit </td>
                <td> : {{$data->publishers->city}}</td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td> : 
                    @php
                        $z = 1;
                    @endphp
                    @foreach($author_name as $an)
                        @if($z == 1)
                            {{$an}}
                        @else
                            , {{$an}}
                        @endif
                    @php
                        $z++;
                    @endphp
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Tahun terbit </td>
                <td> : {{$data->publish_year}}</td>
            </tr>
            <tr>
                <td>Tahun pengadaan pertama </td>
                <td> : {{$data->purchase_year}}</td>
            </tr>
            <tr>
                <td>Kelas DDC </td>
                <td> : {{$data->ddc}}</td>
            </tr>
            <tr>
                <td>Klasifikasi </td>
                <td> : {{$data->classification}}</td>
            </tr>
            <tr>
                <td>Edisi </td>
                <td> : {{$data->edition}}</td>
            </tr>
            <tr>
                <td>Jumlah halaman </td>
                <td> : {{$data->page}}</td>
            </tr>
            <tr>
                <td>Tinggi buku </td>
                <td> : {{$data->book_height}} cm</td>
            </tr>
            <tr>
                <td>Lokasi buku </td>
                <td> : {{$data->location}}</td>
            </tr>
        </tbody>
    </table>    
    <div style="float: right;">
        <button href="#modalCreate" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Item</button>           
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nomor registrasi buku</th>
            <th>Sumber</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @if($item->is_deleted == 0)
                    <tr>
                        <td>{{$item->register_num}}</td>
                        <td>
                            @if( $item->source== "pembelian")
                                Pembelian
                            @else
                                Hadiah
                            @endif
                        </td>
                        <td>{{$item->price}}</td>
                        @if($item->status == "tersedia")
                            <td style="background-color: rgb(113, 255, 113)">
                                Tersedia
                            </td>
                        @else
                            <td style="background-color: rgb(255, 64, 64)">
                                Sedang Dipinjam
                            </td>
                        @endif
                        <td>
                            <a href="#modalEdit" data-toggle="modal" class="btn btn-warning" onclick="getEditForm('{{$item->register_num}}')">Ubah</a>
                            {{-- onclick="getEditForm({{$publisher->id}})" --}}
                            <a class="btn btn-danger" onclick="if(confirm('Apakah anda yakin menghapus data {{$item->register_num}}'))">Hapus</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
  </table>
</div>


{{-- Modal start Add--}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        {{-- Form start --}}
        <form role="form" method="POST" action="{{route('daftar-item.store')}}">
          <div class="modal-header">
            <button type="button" class="close" 
              data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Tambah Data Item Buku</h4>
          </div>
          <div class="modal-body">
          {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nomor ID Buku</label>
                    <input name="id" type="text" class="form-control" value="{{$data->id}}" readonly >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Judul Buku</label>
                    <input name="title" type="text" class="form-control" value="{{$data->title}}" readonly >
                </div>
                <div class="form-group">
                    <label>Nomor ISBN</label>
                    <input name="isbn" type="text" class="form-control" value="{{$data->isbn}}" readonly >
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label>Sumber Buku :</label><br>
                        <select name="source" id="source">
                            <option value="pembelian">Pembelian</option>
                            <option value="hadiah">Hadiah</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input name="price" type="number" class="form-control" placeholder="Isikan harga buku" name="price">
                    <span class="help-block">
                    Tulis harga buku. Jika sumber buku adalah hadiah, maka isikan 0</span>
                </div>
                <div class="form-group">
                    <label>Tahun Pengadaan</label>
                    <input name="year" type="number" class="form-control" placeholder="Isikan tahun pengadaan item buku" name="year">
                    <span class="help-block">
                    Tulis tahun pengadaan item buku. Contoh: 2010</span>
                </div>
            </div>  
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Simpan</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
           </div>
        </form>
        {{-- Form end --}}
      </div>    
    </div>
  </div>
  {{-- Modal end --}}

  {{-- Modal start Edit--}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
            <div class="modal-header">
            <button type="button" class="close" 
                data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Ubah Data Item Buku</h4>
            </div>
            {{-- Isinya dari editItem.blade.php --}}
        </div>
        </div>
    </div>
  {{-- Modal end edit --}}
</body>
</html>

<script type="text/javascript">
    function getEditForm(id) {
    $.ajax({
        type:'POST',
        url:'{{route("daftar-item.getEditForm")}}',
        data:{
              '_token': '<?php echo csrf_token() ?>',
              'id':id
            },
        success:function(data) {
            $("#modalContent").html(data.msg);
        }
    });
    }
  
    function updateData(id)
      {
        var eSource=$('#eSource').val();
        var ePrice =$('#ePrice').val();
        var eYear = $('#eYear').val();
        $.ajax({
            type:'POST',
            url:'{{route("daftar-item.updateData")}}',
            data:{
                  '_token': '<?php echo csrf_token() ?>',
                  'id':id,
                  'source':eSource,
                  'price':ePrice,
                  'year' : eYear
                },
            success:function(data) {
              location.reload();
            }
        });
      }
  </script>
