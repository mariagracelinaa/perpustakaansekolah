@extends('layouts.gentelella')

@section('content')

<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Penerbit</small></h2>
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
                  <th>Nama Penerbit</th>
                  <th>Kota</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php $no = 1; @endphp
                @foreach ($result as $publisher)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$publisher->name}}</td>
                    <td>{{$publisher->city}}</td>
                    <td style="width: 5%;">
                      <div class="container">
                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="#modalEdit" data-toggle="modal" class="btn" onclick="getEditForm({{$publisher->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a>
                          {{-- <li>
                            <a class="btn" onclick="if(confirm('Apakah anda yakin menghapus data {{$publisher->name}}'))"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
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
      <form role="form" method="POST" id="add_publisher">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Penerbit</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label>Nama Penerbit</label><span style="color: red"> *</span>
                    <input type="text" required class="form-control" placeholder="Isikan nama penerbit" name="name">
                    <span class="text-danger error-text name_error"></span>
                </div>
                <div class="form-group">
                    <label>Kota Penerbit</label><span style="color: red"> *</span>
                    <input type="text" required class="form-control" placeholder="Isikan kota penerbit" name="city">
                    <span class="text-danger error-text city_error"></span>
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
        <h4 class="modal-title">Ubah Data Penerbit</h4>
      </div>
      {{-- Isinya dari getEditForm.blade.php --}}
    </div>
  </div>
</div>
{{-- Modal end edit --}}
@endsection

@section('javascript')
  <script type="text/javascript">
    function getEditForm(id) {
      $.ajax({
          type:'POST',
          url:'{{route("daftar-penerbit.getEditForm")}}',
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
      var eName=$('#eName').val();
      var eCity =$('#eCity').val();
      $.ajax({
        type:'POST',
        url:'{{route("daftar-penerbit.updateData")}}',
        data:{
          '_token': '<?php echo csrf_token() ?>',
          'id':id,
          'name':eName,
          'city':eCity
        },
        success:function(data) {
          location.reload();
        }
      });
    }

    function submitAdd(){
    var formData = new FormData($("#add_publisher")[0]);
      $.ajax({
            url: "{{url('daftar-penerbit')}}",
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