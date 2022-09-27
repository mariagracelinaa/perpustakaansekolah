@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Buku</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <button href="#modalCreate" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>  
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
                  <th>No</th>
                  <th>Judul</th>
                  <th>ISBN</th>
                  <th>Tahun Terbit</th>
                  <th>Pertama Pengadaan</th>
                  <th>Kelas DDC</th>
                  <th>Nomor Panggil</th>
                  <th>Edisi</th>
                  <th>Jumlah Halaman</th>
                  <th>Tinggi Buku (cm)</th>
                  <th>Lokasi</th>
                  <th>Penerbit</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($result as $biblio)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$biblio->title}}</td>
                    <td>{{$biblio->isbn}}</td>
                    <td>{{$biblio->publish_year}}</td>
                    <td>{{$biblio->first_purchase}}</td>
                    <td>{{$biblio->ddc}}</td>
                    <td>{{$biblio->classification}}</td>
                    <td>{{$biblio->edition}}</td>
                    <td>{{$biblio->page}}</td>
                    <td>{{$biblio->book_height}}</td>
                    <td>{{$biblio->location}}</td>
                    <td>{{$biblio->publishers->name}}</td>
                    <td>
                      <div class="container">
                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu">
                          <li><a href="#modalEdit" data-toggle="modal" class="btn links" onclick="getEditForm({{$biblio->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                          <li>
                            <a class="btn links" href="daftar-buku-detail/{{$biblio->id}}"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</a>
                          </li>
                        </ul>
                      </div>
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


{{-- Modal start Add--}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" >
      {{-- Form start --}}
      <form id="add_biblio" role="form" method="POST">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Buku</h4>
        </div>
        <div class="modal-body">
            @csrf
            <div class="alert alert-danger" style="display:none"></div>
            <div class="form-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Judul Buku</label>
                    <input id="title" type="text" class="form-control" placeholder="Tulis judul buku dengan lengkap" name="title">
                    <span class="text-danger error-text title_error"></span>
                </div>
                <div class="form-group">
                    <label>Nomor ISBN</label>
                    <input id="isbn" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis nomor ISBN 10 atau 13" name="isbn">
                    <span class="text-danger error-text isbn_error"></span>
                </div>
                {{-- Penerbit, nanti dibuat bisa search --}}
                <div class="form-group">
                  <label>Penerbit</label><br>
                  <input id="publisher" name="listPublisher" list="listPublisher" placeholder="Tulis nama penerbit">
                    <datalist id="listPublisher">
                      <select id="selectedPublisher">
                      @foreach ($publisher as $pub)
                        <option idp="{{$pub->id}}" value="{{$pub->name}}">
                      @endforeach</select>
                  </datalist> 
                  <br><span class="text-danger error-text listPublisher_error"></span>
                </div>
                {{-- Penerbit, nanti dibuat bisa search --}}
                {{-- Penulis, nanti dibuat bisa search --}}
                <div class="form-group">
                  <label>Penulis</label><br>
                  <table class="table" id="dynamic_field">
                    <tr>
                      <td>
                        {{-- <input type="number" class="form-control" placeholder="Isikan nama penulis" name="author[]" id="author"> --}}
                        <input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis">
                        <datalist id="listAuthor">
                          @foreach ($author as $aut)
                            <option idp="{{$aut->id}}" value="{{$aut->name}}">
                          @endforeach
                        </datalist>
                        <span class="text-danger error-text listAuthor_error"></span>
                      </td>
                      <td>
                        <button type="button" name="add" id="add" class="btn btn-light"><i class="fa fa-plus"></i> Tambah Penulis</button>
                      </td>
                    </tr>
                  </table>
                </div>
                {{-- Penulis, nanti dibuat bisa search --}}
                <div class="form-group">
                  <label>Tahun Terbit</label>
                  <input id="publish_year" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis tahun terbit buku" name="publish_year">
                  <span class="text-danger error-text publish_year_error"></span>
                </div>
                <div class="form-group">
                  <label>Tahun Pengadaan</label>
                  <input id="first_purchase" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan tahun pengadaan buku di perpustakaan pertama kali" name="first_purchase">
                  <span class="text-danger error-text first_purchase_error"></span>
                </div>
                {{-- Combobox DDC --}}
                <div class="form-group">
                  <label for="ddc">Pilih kelas DDC:</label>
                  <select name="ddc" id="ddc">
                    <option value="000">000 - Karya Umum</option>
                    <option value="100">100 - Filsafat</option>
                    <option value="200">200 - Agama</option>
                    <option value="300">300 - Ilmu Sosial</option>
                    <option value="400">400 - Bahasa</option>
                    <option value="500">500 - Ilmu Murni</option>
                    <option value="600">600 - Ilmu Terapan</option>
                    <option value="700">700 - Kesenian dan Olahraga</option>
                    <option value="800">800 - Kesusastraan</option>
                    <option value="900">900 - Sejarah dan Geografi</option>
                  </select>
                  <span class="text-danger error-text ddc_error"></span>
                </div>
                {{-- Combobox DDC --}}
                <div class="form-group">
                  <label>Nomor Panggil</label>
                  <input id="classification" type="text" class="form-control" placeholder="Tulis nomor panggil buku dengan lengkap. Contoh: 813 Sus r" name="classification">
                  <span class="text-danger error-text classification_error"></span>
                </div>
                {{-- Ini nanti buat upload gambar --}}
                <div class="form-group">
                  <label>Gambar Buku</label>
                  <input type="file" class="form-control" name="image" id="image">
                  <span class="help-block">
                    Pilih gambar buku. Jika tidak ada, dapat dilewati</span>
                </div>
                {{-- Ini nanti buat upload gambar --}}
                <div class="form-group">
                  <label>Edisi</label>
                  <input id="edition" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis edisi buku. Jika tidak ada, tuliskan 1" name="edition">
                  <span class="text-danger error-text edition_error"></span>
                </div>
                <div class="form-group">
                  <label>Jumlah Halaman</label>
                  <input id="page" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan jumlah halaman buku" name="page">
                  <span class="text-danger error-text page_error"></span>
                </div>
                <div class="form-group">
                  <label>Tinggi Buku</label>
                  <input id="height" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" class="form-control" placeholder="Isikan tinggi buku" name="height">
                  <span class="text-danger error-text height_error"></span>
                </div>
                <div class="form-group">
                  <label for="location">Pilih Lokasi Rak Buku:</label>
                  <select name="location" id="location">
                    <option value="rak 000">Rak 000 - Karya Umum</option>
                    <option value="rak 100">Rak 100 - Filsafat</option>
                    <option value="rak 200">Rak 200 - Agama</option>
                    <option value="rak 300">Rak 300 - Ilmu Sosial</option>
                    <option value="rak 400">Rak 400 - Bahasa</option>
                    <option value="rak 500">Rak 500 - Ilmu Murni</option>
                    <option value="rak 600">Rak 600 - Ilmu Terapan</option>
                    <option value="rak 700">Rak 700 - Kesenian dan Olahraga</option>
                    <option value="rak 800">Rak 800 - Kesusastraan</option>
                    <option value="rak 900">Rak 900 - Sejarah dan Geografi</option>
                  </select>
                  <span class="text-danger error-text location_error"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" name="submit" onclick="submitAdd()" class="btn btn-info">Simpan</button>
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
        <h4 class="modal-title">Ubah Data Buku</h4>
      </div>
      {{-- Isinya dari getEditForm.blade.php --}}
    </div>
  </div>

{{-- Modal end edit --}}
@endsection


@section('javascript')
<script type="text/javascript">  
  $(document).ready(function(){
    var i=1; 
    $('#add').click(function(){ 
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'"><td><input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis"><datalist id="listAuthor">@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');    
    }); 
      
    $(document).on('click', '.btn_remove', function(){    
      var button_id = $(this).attr("id");     
      $('#row'+button_id+'').remove();    
    }); 
  });
     
  function submitAdd(){
    var formData = new FormData($("#add_biblio")[0]);
      $.ajax({
            url: '{{route("daftar-buku.store")}}',
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
                window.location.href = "{{route('daftar-buku.index')}}";
              }
            }
        }); 
  }


  function getEditForm(id) {
    $.ajax({
        type:'POST',
        url:'{{route("daftar-buku.getEditForm")}}',
        data:{
              '_token': '<?php echo csrf_token() ?>',
              'id':id
            },
        success:function(data) {
            $("#modalContent").html(data.msg);
        }
    });
  }

  function updateBiblio(id)
  {
    var formData = new FormData($("#edit_biblio")[0]);
        $.ajax({
            async: true,
            url: '{{route("daftar-buku.updateData")}}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
          beforeSend:function(){
            $(document).find('span.eEror-text').text('');
          },
          success:function(data) {
            if(data.status == 0){
              $.each(data.errors, function(prefix, val){
                $('span.'+ prefix +'_eError').text(val[0]);
              });
            }else{
              window.location.href = "{{route('daftar-buku.index')}}";
            }
          }
    });
  }

  
</script>
@endsection
 
