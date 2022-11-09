@extends('layouts.gentelella')

@section('content')
<h2>Detail Buku</h2>
    <table>
        <tbody>
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
                <td> : {{$data->first_purchase}}</td>
            </tr>
            <tr>
                <td>Sinopsis </td>
                <td> : {!! nl2br(e($data->synopsis)) !!} </td>
            </tr>
            <tr>
                <td>Kelas DDC </td>
                <td> : {{$data->ddc}}</td>
            </tr>
            <tr>
                <td>Nomor Panggil </td>
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
    <br> 
    <div>
        <img src= "{{asset('images/'.$data->image)}}" height="150px">
    </div> 
    <br>
    <div class="container"> 
        <div class="row">
          <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Daftar Item Buku</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <button href="#modalCreate" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Item</button>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <table id="custometable" class="table table-striped table-bordered" style="width:100%">
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
                                            <td style="text-align: right">{{number_format($item->price)}}</td>
                                            @if($item->status == "tersedia")
                                                <td style="background-color: rgb(113, 255, 113)">
                                                    Tersedia
                                                </td>
                                            @else
                                                <td style="background-color: rgb(255, 64, 64)">
                                                    Sedang Dipinjam
                                                </td>
                                            @endif
                                            <td style="width: 5%;">
                                                <div class="container">
                                                    <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                    <ul class="dropdown-menu">
                                                      <li><a href="#modalEdit" data-toggle="modal" class="btn" onclick="getEditForm('{{$item->register_num}}')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                                                      <li>
                                                        <a href="#modalDelete" data-toggle="modal" class="btn" onclick="getDeleteForm('{{$item->register_num}}')"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                                                      </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

{{-- Modal start Add--}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        {{-- Form start --}}
        <form role="form" method="POST" id="add_item">
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
                    <input name="price" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan harga buku" name="price">
                    <span class="help-block">
                    Tulis harga buku. Jika sumber buku adalah hadiah, maka isikan 0</span>
                </div>
                <div class="form-group">
                    <label>Tahun Pengadaan</label><span style="color: red"> *</span>
                    <input name="year" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan tahun pengadaan item buku. Contoh: 2010" name="year">
                    <span class="text-danger error-text year_error"></span>
                </div>
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" onclick="submitAdd()">Simpan</button>
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

  {{-- Modal start delete--}}
<div class="modal fade" id="modalDelete" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modalContentDelete">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Hapus Data Item Buku</h4>
        </div>
        {{-- Isinya dari deleteItem.blade.php --}}
      </div>
    </div>
  </div>
  {{-- Modal end delete --}}
@endsection

@section('javascript')
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
        var biblios_id = $('#biblios_id').val();
        $.ajax({
            type:'POST',
            url:'{{route("daftar-item.updateData")}}',
            data:{
                  '_token': '<?php echo csrf_token() ?>',
                  'reg_num':id,
                  'source':eSource,
                  'price':ePrice,
                  'year' : eYear
                },
            success:function(data) {
              location.reload();
                // if(data.status == 'success'){
                //     alert('Data item buku berhasil diubah');
                // }else{
                //     alert('gagal');
                // }
            }
        });
      }

    function getDeleteForm(id) {
        $.ajax({
            type:'POST',
            url:'{{route("daftar-item.getDeleteForm")}}',
            data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id
                },
            success:function(data) {
                $("#modalContentDelete").html(data.msg);
            }
        });
    }

    function deleteData(id)
    {
        var formData = new FormData($("#delete_item")[0]);
        $.ajax({
            async: true,
            url: '{{route("daftar-item.deleteData")}}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success:function(data) {
                location.reload();
                // window.location.href = "{{route('daftar-buku.index')}}";
            }
        });
    }

    function submitAdd(){
    var formData = new FormData($("#add_item")[0]);
      $.ajax({
            url: "{{route('daftar-item.store')}}",
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data) {
              if(data.status == 0){
                $.each(data.errors, function(prefix, val){
                  $('span.'+ prefix +'_error').text(val[0]);
                });
              }else{
                location.reload();
              }
            }
        }); 
  }
  </script>
@endsection