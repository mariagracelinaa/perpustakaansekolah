{{-- Form start --}}
<form role="form" method="POST" action="">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Usulan</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label>Nama Pengusul</label>
                <input type="text" class="form-control" placeholder="Isikan nama penerbit" name="name" value="{{$data->users->name}}" readonly>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" class="form-control" placeholder="Isikan kota penerbit" name="title" value="{{$data->title}}" readonly>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" class="form-control" placeholder="Isikan kota penerbit" name="author" value="{{$data->author}}" readonly>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" class="form-control" placeholder="Isikan kota penerbit" name="publisher" value="{{$data->publisher}}" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Usulan</label>
                <input type="text" class="form-control" placeholder="Isikan kota penerbit" name="date" value="{{ Carbon\Carbon::parse($data->date)->format('d-m-Y') }}" readonly>
            </div>
            <div class="form-group">
                <label for="eStatus">Pilih Lokasi Rak Buku:</label>
                <select name="eStatus" id="eStatus">
                    @if($data->status == "proses review")
                        <option value="proses review" selected >Proses Review</option>
                    @else
                        <option value="proses review">Proses Review</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->status == "ditolak")
                        <option value="ditolak" selected >Ditolak</option>
                    @else
                        <option value="ditolak">Ditolak</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->status == "diterima")
                        <option value="diterima" selected >Diterima</option>
                    @else
                        <option value="diterima">Diterima</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->status == "selesai")
                        <option value="selesai"selected >Selesai</option>
                    @else
                        <option value="selesai">Selesai</option>
                    @endif
                </select>
                <span class="text-danger eError-text location_eError"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" data-dismiss="modal" onclick="updateData({{$data->id}})">Ubah</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}