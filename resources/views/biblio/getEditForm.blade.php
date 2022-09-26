<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- Form start --}}
<form id="edit_biblio" role="form" method="POST">
    <div class="modal-header">
      <button type="button" class="close" 
        data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title">Ubah Data Buku</h4>
    </div>
    <div class="modal-body">
        @csrf
        {{-- @method('PUT') --}}
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">ID Buku</label>
                <input id="id" type="text" class="form-control" placeholder="Isikan judul buku" name="id" value="{{$data->id}}" readonly>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Judul Buku</label>
                <input id="title" type="text" class="form-control" placeholder="Tulis judul buku dengan lengkap" name="title" value="{{$data->title}}">
                <span class="text-danger eError-text title_eError"></span>
            </div>
            <div class="form-group">
                <label>Nomor ISBN</label>
                <input id="isbn" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis nomor ISBN 10 atau 13" name="isbn" value="{{$data->isbn}}">
                <span class="text-danger eError-text isbn_eError"></span>
            </div>
            <div class="form-group">
              <label>Penerbit</label><br>
              <input id="publisher" name="listPublisher" list="listPublisher" placeholder="Tulis nama penerbit" value="{{$data->publishers->name}}">
                <datalist id="listPublisher">
                    <select id="selectedPublisher">
                        @foreach ($publisher as $pub)
                            <option idp="{{$pub->id}}" value="{{$pub->name}}">
                        @endforeach
                    </select>
                </datalist> 
                <span class="text-danger eError-text listPublisher_eError"></span>
            </div>
            <div class="form-group">
              <label>Penulis</label><br>
              @php
                  $i = 0;
              @endphp
              <table class="table" id="dynamic_field2">
                @foreach($author_data as $ad)
                    @if($i == 0)
                        <tr>
                            <td>
                                <input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis" value="{{$ad}}">
                                <datalist id="listAuthor">
                                    @foreach ($author as $aut)
                                        <option idp="{{$aut->id}}" value="{{$aut->name}}"> 
                                    @endforeach
                                </datalist>
                            </td>
                            
                            <td>
                                <button type="button" name="add" id="edit" class="btn btn-light"><i class="fa fa-plus"></i> Tambah Penulis</button>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @else
                        <tr id="{{$i}}">
                            <td>
                                <input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis" value="{{$ad}}">
                                <datalist id="listAuthor">
                                    @foreach ($author as $aut)
                                        <option idp="{{$aut->id}}" value="{{$aut->name}}">
                                    @endforeach</datalist>
                                </td>
                            <td>
                                <button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
              </table>
              <span class="text-danger eError-text listAuthor_eError"></span>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input id="publish_year" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis tahun terbit buku" name="publish_year" value="{{$data->publish_year}}">
                <span class="text-danger eError-text publish_year_eError"></span>
            </div>
            <div class="form-group">
                <label>Tahun Pengadaan</label>
                <input id="first_purchase" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis tahun pengadaan buku di perpustakaan pertama kali" name="first_purchase" value="{{$data->first_purchase}}">
                <span class="text-danger eError-text first_purchase_eError"></span>
            </div>
            {{-- Combobox DDC --}}
            <div class="form-group">
                <label for="ddc">Pilih kelas DDC:</label>
                <select name="ddc" id="ddc">
                    @if($data->ddc == "000")
                        <option value="000" selected >000 - Karya Umum</option>
                    @else
                        <option value="000">000 - Karya Umum</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "100")
                        <option value="100" selected >100 - Filsafat</option>
                    @else
                        <option value="100">100 - Filsafat</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "200")
                        <option value="200" selected >200 - Agama</option>
                    @else
                        <option value="200">200 - Agama</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "300")
                        <option value="300" selected >300 - Ilmu Sosial</option>
                    @else
                        <option value="300">300 - Ilmu Sosial</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "400")
                        <option value="400" selected >400 - Bahasa</option>
                    @else
                        <option value="400">400 - Bahasa</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "500")
                        <option value="500" selected >500 - Ilmu Murni</option>
                    @else
                        <option value="500">500 - Ilmu Murni</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "600")
                        <option value="600" selected >600 - Ilmu Terapan</option>
                    @else
                        <option value="600">600 - Ilmu Terapan</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "700")
                        <option value="700" selected >700 - Kesenian dan Olahraga</option>
                    @else
                        <option value="700">700 - Kesenian dan Olahraga</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "800")
                        <option value="800" selected >800 - Kesusastraan</option>
                    @else
                        <option value="800">800 - Kesusastraan</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->ddc == "900")
                        <option value="900" selected >900 - Sejarah dan Geografi</option>
                    @else
                        <option value="900">900 - Sejarah dan Geografi</option>
                    @endif
                </select>
                <span class="text-danger eError-text ddc_eError"></span>
            </div>
            {{-- Combobox DDC --}}
            <div class="form-group">
                <label>Nomor Panggil</label>
                <input id="classification" type="text" class="form-control" placeholder="Tulis nomor panggil buku dengan lengkap. Contoh: 813 Sus r" name="classification" value="{{$data->classification}}">
                <span class="text-danger eError-text classification_eError"></span>
            </div>
            {{-- Ini nanti buat upload gambar --}}
            <div class="form-group">
                <label>Gambar Buku</label>
                <br>
                <img src= "{{asset('images/'.$data->image)}}" height="150px">
                <p>{{$data->image}}</p>
                <input type="file" class="form-control" name="image" id="image">
                <span class="help-block">Pilih gambar buku. Jika tidak ada, dapat dilewati</span>
            </div>
            {{-- Ini nanti buat upload gambar --}}
            <div class="form-group">
                <label>Edisi</label>
                <input id="edition" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Tulis edisi buku. Jika tidak ada, tuliskan 1" name="edition" value="{{$data->edition}}">
                <span class="text-danger eError-text edition_eError"></span>
            </div>
            <div class="form-group">
                <label>Jumlah Halaman</label>
                <input id="page" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan jumlah halaman buku" name="page" value="{{$data->page}}">
                <span class="text-danger eError-text page_eError"></span>
            </div>
            <div class="form-group">
                <label>Tinggi Buku</label>
                <input id="height" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Isikan tinggi buku" name="height" value="{{$data->book_height}}">
                <span class="text-danger eError-text height_eError"></span>
            </div>
            <div class="form-group">
                <label for="location">Pilih Lokasi Rak Buku:</label>
                <select name="location" id="location">
                    @if($data->location == "rak 000")
                        <option value="rak 000" selected >Rak 000 - Karya Umum</option>
                    @else
                        <option value="rak 000">Rak 000 - Karya Umum</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 100")
                        <option value="rak 100" selected >Rak 100 - Filsafat</option>
                    @else
                        <option value="rak 100">Rak 100 - Filsafat</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 200")
                        <option value="rak 200" selected >Rak 200 - Agama</option>
                    @else
                        <option value="rak 200">Rak 200 - Agama</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 300")
                        <option value="rak 300"selected >Rak 300 - Ilmu Sosial</option>
                    @else
                        <option value="rak 300">Rak 300 - Ilmu Sosial</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 400")
                        <option value="rak 400"selected >Rak 400 - Bahasa</option>
                    @else
                        <option value="rak 400">Rak 400 - Bahasa</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 500")
                        <option value="rak 500"selected >Rak 500 - Ilmu Murni</option>
                    @else
                        <option value="rak 500">Rak 500 - Ilmu Murni</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 600")
                        <option value="rak 600" selected >Rak 600 - Ilmu Terapan</option>
                    @else
                        <option value="rak 600">Rak 600 - Ilmu Terapan</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 700")
                        <option value="rak 700"selected >Rak 700 - Kesenian dan Olahraga</option>
                    @else
                        <option value="rak 700">Rak 700 - Kesenian dan Olahraga</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 800")
                        <option value="rak 800" selected >Rak 800 - Kesusastraan</option>
                    @else
                        <option value="rak 800">Rak 800 - Kesusastraan</option>
                    @endif
                    {{-- ------------------------------------------------------------------------------- --}}
                    @if($data->location == "rak 900")
                        <option value="rak 900" selected >Rak 900 - Sejarah dan Geografi</option>
                    @else
                        <option value="rak 900">Rak 900 - Sejarah dan Geografi</option>
                    @endif
                </select>
                <span class="text-danger eError-text location_eError"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick="updateBiblio({{$data->id}})">Ubah</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
     </div>
  </form>
  {{-- Form end --}}
  <script type="text/javascript"> 
    $('#edit').click(function(){
        $('#dynamic_field2').append('<tr id="{{$i}}"><td><input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis"><datalist id="listAuthor">@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist></td><td><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');    
    }); 

    $(document).on('click', '.btn_remove', function(){    
           var button_id = $(this).attr("id");     
           $('#'+button_id+'').remove();    
    });
  </script>