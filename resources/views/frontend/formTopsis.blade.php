@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/rekomendasi-buku')}}">
            @csrf
            {{-- <input type="hidden" name="id" value="{{$data->id}}"> --}}
            <div class="form-group">
              <label>Kategori Buku</label><span style="color: red"> *</span><br>
              <select name="category" id="category" class="form-control" style="background-color: white">
                <option value="1000">--- Pilih Kategori ---</option>
                <option value="000" style="font-weight: bold">Karya Umum (Ilmu perpustakaan, ensiklopedia umum, penerbitan dan surat kabar)</option>
                {{-- sub category 000 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 000)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="100" style="font-weight: bold">Filsafat (Psikologi, etika, logika, filsafat modern, metafisika)</option>
                {{-- sub category 100 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 100)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="200" style="font-weight: bold">Agama (Alkitab, Agama Kristen)</option>
                {{-- sub category 200 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 200)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="300" style="font-weight: bold">Ilmu Sosial (Ilmu ekonomi, masalah sosial, pendidikan)</option>
                {{-- sub category 300 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 300)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="400" style="font-weight: bold">Bahasa (Bahasa indonesia, bahasa inggris,bahasa lainnya)</option>
                {{-- sub category 400 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 400)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="500" style="font-weight: bold">Ilmu Murni (biologi, kimia, fisika, matematika, ilmu tumbuhan, astronomi)</option>
                {{-- sub category 500 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 500)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="600" style="font-weight: bold">Ilmu Terapan (Pertanian, kesejahteraan rumah tangga, manajemen)</option>
                {{-- sub category 600 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 600)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="700" style="font-weight: bold">Kesenian dan Olahraga (Menggambar, seni lukis, seni musik, olahraga)</option>
                {{-- sub category 700 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 700)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="800" style="font-weight: bold">Kesusastraan (Kesusastraan indonesia, kesusastraan inggris, novel fiksi)</option>
                {{-- sub category 800 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 800)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
                <option value="900" style="font-weight: bold">Sejarah dan Geografi (Geografi umum, biografi, sejarah umum dunia)</option>
                {{-- sub category 900 --}}
                @foreach ($category as $cat)
                    @if ($cat->ddc == 900)
                        <option value="{{$cat->id}}">&nbsp &nbsp{{ucfirst($cat->name)}}</option>
                    @endif
                @endforeach
              </select>
            </div>
            <div class="form-group" id="dynamic_field">
                <label>Siapa penulis buku yang paling Anda sukai?</label>
                <div style="text-align: left">
                    <select name="fav_author" id="fav_author"  class="form-control" style="background-color: white" disabled>
                        <option value="">-- Pilih nama penulis --</option>
                    </select>
                    {{-- <input id="fav_author" name="fav_author" list="listAuthor" style="width: 500px" placeholder="Tulis nama penulis">
                    <datalist id="listAuthor" >
                        @foreach ($author as $aut)
                            <option idp="{{$aut->id}}" value="{{$aut->name}}">
                        @endforeach
                    </datalist>
                    <td>
                        <button type="button" name="add" id="add" class="btn btn-light"><i class="fa fa-plus"></i> Tambah Penulis</button>
                    </td> --}}
                </div>   
            </div>
            <div class="form-group">
                <label>Seberapa penting bagi Anda buku yang direkomendasikan merupakan buku yang telah banyak dipinjam?</label><br>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_borrow" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_borrow" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_borrow" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_borrow" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_borrow" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah buku yang tebal cocok bagi Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Cocok</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_page" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_page" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_page" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_page" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_page" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Cocok</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah koleksi buku baru di perpustakaan lebih cocok untuk Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Cocok</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_age" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_age" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_age" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_age" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_age" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Cocok</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah ketersediaan buku di perpustakaan penting bagi Anda? (Tidak harus menunggu/pesan, dapat langsung dipinjam)</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_stock" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_stock" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_stock" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_stock" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_stock" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah rating buku penting bagi Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_book_rating" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_book_rating" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_book_rating" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_book_rating" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_book_rating" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah rating penulis penting Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_author_rating" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_author_rating" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_author_rating" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_author_rating" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_author_rating" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-primary" style="width:200px; margin-top: 10px; border-radius: 15px;">Cari Rekomendasi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            // var i=1; 
            // $('#add').click(function(){ 
            //     i++;
            //     // $('#dynamic_field').append('<tr id="row'+i+'"><td><input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis"><datalist id="listAuthor">@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');   
                    
            //     $('#dynamic_field').append('<div style="text-align: left" id="row'+i+'"><input id="author" name="listAuthor[]" list="listAuthor" style="width: 500px" placeholder="Tulis nama penulis"><datalist id="listAuthor" >@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></div>');
            // }); 
            
            // $(document).on('click', '.btn_remove', function(){    
            //     var button_id = $(this).attr("id");     
            //     $('#row'+button_id+'').remove();    
            // }); 
        });

        // Untuk disable/visible filter
        $("#category").change(function () {
            var cat = $('#category').val();
            if(cat == 1000){
                $("#fav_author").attr('disabled', 'disabled');
            }else{
                $("#fav_author").removeAttr("disabled");
                // alert($cat);
                $.ajax({
                    type:'POST',
                    url:'{{url("/daftar-penulis-combobox")}}',
                    data:{
                        '_token': '<?php echo csrf_token() ?>',
                        'cat': cat
                        },
                    success:function(data) {
                        $('#fav_author').html('');
                        $("#fav_author").append('<option value="">-- Pilih nama penulis --</option>');
                        $.each(data.data, function(key, value) {
                            $("#fav_author").append(
                                "<option value='"+value.id+"'>"+value.name+"</option>");
                        });
                    }
                });
            }
        });
    </script>
@endsection