<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- Form start --}}
<form role="form" method="POST" action="">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Item Buku</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Nomor ID Buku</label>
                <input name="id" type="text" class="form-control" value="{{$data[0]->biblios->id}}" readonly >
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
                <div class="form-group">
                    <label>Sumber Buku :</label><br>
                    <select name="source" id="eSource">
                        @if($data[0]->source == "pembelian")
                            <option value="pembelian" selected >Pembelian</option>
                        @else
                            <option value="pembelian">Pembelian</option>    
                        @endif

                        @if($data[0]->source == "hadiah")
                            <option value="hadiah" selected >Hadiah</option>
                        @else
                             <option value="hadiah">Hadiah</option> 
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input id="ePrice" name="price" type="number" class="form-control" placeholder="Isikan harga buku" name="price" value="{{$data[0]->price}}">
                <span class="help-block">
                Tulis harga buku. Jika sumber buku adalah hadiah, maka isikan 0</span>
            </div>
            <div class="form-group">
                <label>Tahun Pengadaan</label>
                <input id="eYear" name="year" type="number" class="form-control" placeholder="Isikan tahun pengadaan item buku" name="year" value="{{$data[0]->purchase_year}}">
                <span class="help-block">
                Tulis tahun pengadaan item buku. Contoh: 2010</span>
            </div>
        </div>  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" data-dismiss="modal" onclick="updateData('{{$data[0]->register_num}}')">Ubah</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}