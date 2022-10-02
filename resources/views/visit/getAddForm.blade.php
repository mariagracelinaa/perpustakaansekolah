{{-- Form start --}}
<form role="form" method="POST">
  <div class="modal-header">
    <button type="button" class="close" 
      data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Tambah Catatan Kunjungan</h4>
  </div>
  <div class="modal-body">
      @csrf
      @method('PUT')
      <div class="form-body">
          <div class="form-group">
              <label>Keperluan Kunjungan</label>
              <input id="desc" type="text" class="form-control" placeholder="Tuliskan keperluan kunjungan di perpustakaan" name="desc" required>
              <span class="text-danger desc_error"></span>
          </div>
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-info" data-dismiss="modal" onclick="submitAdd({{$data->id}})">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
   </div>
</form>
{{-- Form end --}}