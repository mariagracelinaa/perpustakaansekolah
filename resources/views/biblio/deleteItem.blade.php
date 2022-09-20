<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- Form start --}}
<form id='delete_item' role="form" method="POST" action="">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Hapus Data Item Buku</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Nomor Registrasi Buku</label>
                <input name="register_num" type="text" class="form-control" value="{{$data[0]->register_num}}" readonly >
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Judul Buku</label>
                <input name="title" type="text" class="form-control" value="{{$data[0]->biblios->title}}" readonly >
            </div>
            <div class="form-group">
                <label>Nomor ISBN</label>
                <input name="isbn" type="text" class="form-control" value="{{$data[0]->biblios->isbn}}" readonly >
            </div>
            <div class="form-group">
                <label>Sumber Buku :</label>
                <input name="source" type="text" class="form-control" value="{{ $data[0]->source === "pembelian" ? "Pembelian" : "Hadiah" }}" readonly >
            </div>
            <div class="form-group">
                <label>Deskripsi :</label>
                <textarea rows="3" id="description" name="desc" type="textarea" class="form-control" placeholder="Isikan deskripsi penghapusan item buku" name="desc"></textarea>
            </div>
        </div>  
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteData('{{$data[0]->register_num}}')">Hapus</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}