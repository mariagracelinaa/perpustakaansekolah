@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/rekomendasi-buku')}}">
            @csrf
            {{-- <input type="hidden" name="id" value="{{$data->id}}"> --}}
            <div class="form-group">
              <label>Kategori Buku</label><br>
              <select name="category" id="category" class="form-control" style="background-color: white">
                <option value="1000">--- Pilih Kategori ---</option>
                <option value="000">Karya Umum</option>
                <option value="100">Filsafat</option>
                <option value="200">Agama</option>
                <option value="300">Ilmu Sosial</option>
                <option value="400">Bahasa</option>
                <option value="500">Ilmu Murni</option>
                <option value="600">Ilmu Terapan</option>
                <option value="700">Kesenian dan Olahraga</option>
                <option value="800">Kesusastraan</option>
                <option value="900">Sejarah dan Geografi</option>
              </select>
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
                <label>Apakah ketebalan buku penting bagi Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
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
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah tahun terbitan buku penting bagi Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_publish" value=1 style="width: 20px; height: 20px">
                        <label class="form-check-label">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_publish" value=2 style="width: 20px; height: 20px">
                        <label class="form-check-label">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_publish" value=3 style="width: 20px; height: 20px" checked>
                        <label class="form-check-label">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_publish" value=4 style="width: 20px; height: 20px">
                        <label class="form-check-label">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio_publish" value=5 style="width: 20px; height: 20px">
                        <label class="form-check-label">5</label>
                    </div>
                    <label>Sangat Penting</label>
                </div>   
            </div>
            <div class="form-group">
                <label>Apakah Anda koleksi buku baru di perpustakaan lebih cocok untuk Anda?</label>
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
                <label>Apakah ketersediaan buku di perpustakaan penting untuk Anda? (Tidak harus menunggu/pesan, dapat langsung dipinjam)</label>
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
            <div class="form-group" id="dynamic_field">
                <label>Siapa penulis buku kesukaan Anda?</label>
                <div style="text-align: left">
                    <input id="author" name="listAuthor[]" list="listAuthor" style="width: 500px" placeholder="Tulis nama penulis">
                    <datalist id="listAuthor" >
                        @foreach ($author as $aut)
                            <option idp="{{$aut->id}}" value="{{$aut->name}}">
                        @endforeach
                    </datalist>
                    <td>
                        <button type="button" name="add" id="add" class="btn btn-light"><i class="fa fa-plus"></i> Tambah Penulis</button>
                    </td>
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
            var i=1; 
            $('#add').click(function(){ 
                i++;
                // $('#dynamic_field').append('<tr id="row'+i+'"><td><input id="author" name="listAuthor[]" list="listAuthor" placeholder="Tulis nama penulis"><datalist id="listAuthor">@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');   
                    
                $('#dynamic_field').append('<div style="text-align: left" id="row'+i+'"><input id="author" name="listAuthor[]" list="listAuthor" style="width: 500px" placeholder="Tulis nama penulis"><datalist id="listAuthor" >@foreach ($author as $aut)<option idp="{{$aut->id}}" value="{{$aut->name}}">@endforeach</datalist><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></div>');
            }); 
            
            $(document).on('click', '.btn_remove', function(){    
            var button_id = $(this).attr("id");     
            $('#row'+button_id+'').remove();    
        }); 
    });
    </script>
@endsection