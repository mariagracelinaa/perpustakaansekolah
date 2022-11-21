{{-- Form start --}}
<form role="form" method="POST">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Kategori</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label>Nama Kategory</label><span style="color: red"> *</span>
                <input id="eName" type="text" class="form-control" placeholder="Isikan nama penulis" name="name" value="{{$data->name}}">
                <span class="text-danger error-text eName_error"></span>
            </div>
            <div class="form-group">
                <label>Kelas DDC :</label><span style="color: red"> *</span><br>
                <select name="eddc" id="eddc" class="form-control">
                    @if ($data->ddc == "000")
                        <option value="000" selected>000 - Karya Umum</option>
                    @else
                        <option value="000">000 - Karya Umum</option>
                    @endif

                    @if ($data->ddc == "100")
                        <option value="100">100 - Filsafat</option>
                    @else
                        <option value="100">100 - Filsafat</option>
                    @endif
                    
                    @if ($data->ddc == "200")
                        <option value="200">200 - Agama</option>
                    @else
                        <option value="200">200 - Agama</option>
                    @endif
                    
                    @if ($data->ddc == "300")
                        <option value="300" selected>300 - Ilmu Sosial</option>
                    @else
                        <option value="300">300 - Ilmu Sosial</option>
                    @endif
                    
                    @if ($data->ddc == "400")
                        <option value="400" selected>400 - Bahasa</option> 
                    @else
                        <option value="400">400 - Bahasa</option>
                    @endif
                    
                    @if ($data->ddc == "500")
                        <option value="500" selected>500 - Ilmu Murni</option>
                    @else
                        <option value="500">500 - Ilmu Murni</option>
                    @endif

                    @if ($data->ddc == "600")
                        <option value="600" selected>600 - Ilmu Terapan</option>
                    @else
                        <option value="600">600 - Ilmu Terapan</option>
                    @endif
                    
                    @if ($data->ddc == "700")
                        <option value="700" selected>700 - Kesenian dan Olahraga</option>
                    @else
                        <option value="700">700 - Kesenian dan Olahraga</option>
                    @endif
                    
                    @if ($data->ddc == "800")
                        <option value="800" selected>800 - Kesusastraan</option>
                    @else
                        <option value="800">800 - Kesusastraan</option>
                    @endif
                    
                    @if ($data->ddc == "900")
                        <option value="900" selected>900 - Sejarah dan Geografi</option>
                    @else
                        <option value="900">900 - Sejarah dan Geografi</option>
                    @endif
                    
                </select>
                <span class="text-danger error-text name_error"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" onclick="updateData({{$data->id}})">Ubah</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}