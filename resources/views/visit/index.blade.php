@extends('layouts.gentelella')

@section('content')
<div class="container"> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Pengguna Perpustakaan</small></h2>
            {{-- <ul class="nav navbar-right panel_toolbox">
              <button href="#modalCreate" data-toggle="modal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>    
            </ul> --}}
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
                  <th>NISN/NIY</th>
                  <th>Nama</th>
                  <th>Kelas/Jabatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @php $no = 1; @endphp
                @foreach ($data as $d)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>
                        @if($d->role = 'murid')
                            {{$d->nisn}}
                        @endif
                        
                        @if($d->role = 'guru/staf')
                            {{$d->niy}}
                        @endif
                    </td>
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
                    <td style="width: 17%;">
                        <ul class="nav navbar-right panel_toolbox">
                            <button href='#modalAdd' data-toggle="modal" type="button" class="btn btn-primary" onclick="getAddForm({{$d->id}})"><i class="fa fa-plus"></i> Tambah Kunjungan</button>    
                        </ul>
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
{{-- Modal start Edit--}}
<div class="modal fade" id="modalAdd" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modalContent">
        <div class="modal-header">
          <button type="button" class="close" 
            data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Tambah Catatan Kunjungan</h4>
        </div>
        {{-- Isinya dari getAddForm.blade.php --}}
      </div>
    </div>
  </div>
  {{-- Modal end edit --}}
@endsection

@section('javascript')
<script>
    function getAddForm(id) {
        $.ajax({
            type:'POST',
            url:'{{route("kunjungan.getAddForm")}}',
            data:{
                '_token': '<?php echo csrf_token() ?>',
                'id':id
                },
            success:function(data) {
                $("#modalContent").html(data.msg);
            }
        });
    }

    function submitAdd(id){
        var desc=$('#desc').val();
        $.ajax({
            type:'POST',
            url:'{{route("kunjungan.addVisit")}}',
            data:{
              '_token': '<?php echo csrf_token() ?>',
              'id':id,
              'desc':desc
            },
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data) {
              if(data.status == 0){
                $.each(data.errors, function(prefix, val){
                  $('span.'+ prefix +'_error').text(val[0]);
                });
              }else{
                window.location.href = "{{url('/kunjungan')}}";
              }
            }
        }); 
    }
</script>
@endsection