{{-- Form start --}}
<form role="form" method="POST" action="">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Penerbit</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Penerbit</label>
                <input id="eName" type="text" class="form-control" placeholder="Isikan nama penerbit" name="name" value="{{$data->name}}">
                <span class="help-block">
                Tulis nama penerbit dengan lengkap</span>
            </div>
            <div class="form-group">
                <label>Kota Penerbit</label>
                <input id="eCity" type="text" class="form-control" placeholder="Isikan kota penerbit" name="city" value="{{$data->city}}">
                <span class="help-block">
                Tulis kota penerbit dengan diawali huruf kapital. Contoh: Jakarta</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" data-dismiss="modal" onclick="updateData({{$data->id}})">Ubah</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}