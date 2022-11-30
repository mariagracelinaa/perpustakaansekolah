@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Kategori Buku</small></h2>
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
                  <th>Nama Kategori</th>
                  <th>Kelas DDC</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($data as $d)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$d->name}}</td>
                    <td>{{$d->ddc}}</td>
                    <td style="width: 5%;">
                      <div class="container">
                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu">
                          <li><a href="#modalEdit" data-toggle="modal" class="btn"  onclick="getEditForm({{$d->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
                          {{-- <li>
                            <a class="btn" onclick="if(confirm('Apakah anda yakin menghapus data {{$aut->name}}'))"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                          </li> --}}
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
      <form role="form" method="POST" id="add_category">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Kategori</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label>Nama Kategori</label><span style="color: red"> *</span>
                    <input type="text" class="form-control" placeholder="Isikan nama kategori" name="name">
                    <span class="text-danger error-text name_error"></span>
                </div>
                <div class="form-group">
                    <label>Kelas DDC :</label><span style="color: red"> *</span><br>
                    <select name="ddc" id="ddc" class="form-control">
                        <option value="">-- Pilih Kelas DDC --</option>
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
                    <span class="text-danger error-text name_error"></span>
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
        <h4 class="modal-title">Ubah Data Kategori</h4>
      </div>
      {{-- Isinya dari getEditForm.blade.php --}}
    </div>
  </div>
</div>
{{-- Modal end edit --}}
@endsection

@section('javascript')
<script>
    function getEditForm(id) {
        $.ajax({
            type:'POST',
            url:'{{url("/daftar-kategori/getEditForm")}}',
            data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id
                },
            success:function(data) {
                $("#modalContent").html(data.msg);
            }
        });
    }

    function submitAdd(){
      var formData = new FormData($("#add_category")[0]);
        $.ajax({
              url: "{{url('/tambah-kategori')}}",
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

    function updateData(id)
    {
      var eName=$('#eName').val();
      var eddc=$('#eddc').val();
      $.ajax({
          type:'POST',
          url:'{{route("daftar-kategori.updateData")}}',
          data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id,
                'eName':eName,
                'eddc' : eddc
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