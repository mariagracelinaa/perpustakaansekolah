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
                <label>Apakah usia buku di perpustakaan penting bagi Anda?</label>
                <div style="text-align: center">
                    <label>Tidak Penting</label>
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