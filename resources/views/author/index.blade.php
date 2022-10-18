@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Penulis</small></h2>
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
                  <th>Nama Penulis</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($result as $aut)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>{{$aut->name}}</td>
                    <td style="width: 5%;">
                      <div class="container">
                        <a class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu">
                          <li><a href="#modalEdit" data-toggle="modal" class="btn" onclick="getEditForm({{$aut->id}})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</a></li>
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
      <form role="form" method="POST" action="{{url('daftar-penulis')}}">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Data Penulis</h4>
        </div>
        <div class="modal-body">
        {{-- the  new supplier form goes here --}}
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Penulis</label>
                    <input type="text" class="form-control" placeholder="Isikan nama penerbit" name="name">
                    <span class="help-block">
                    Tulis nama penulis dengan lengkap</span>
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
        <h4 class="modal-title">Ubah Data Penulis</h4>
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
        url:'{{route("daftar-penulis.getEditForm")}}',
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
      $.ajax({
          type:'POST',
          url:'{{route("daftar-penulis.updateData")}}',
          data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id,
                'name':eName
              },
          success:function(data) {
            location.reload();
          }
      });
    }
</script>
@endsection