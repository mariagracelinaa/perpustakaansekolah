{{-- Form start --}}
<form role="form" method="POST" action="{{route('daftar-penulis.update',$data->id)}}">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Penulis</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Penulis</label>
                <input id="#eName" type="text" class="form-control" placeholder="Isikan nama penulis" name="name" value="{{$data->name}}">
                <span class="help-block">
                Tulis nama penulis dengan lengkap</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" data-dismiss="modal"  onclick="update">Ubah</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}