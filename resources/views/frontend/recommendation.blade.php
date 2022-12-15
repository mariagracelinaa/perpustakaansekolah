@extends('layouts.front')
<style>
    .input-icons i {
            position: absolute;
        }
          
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            padding: 10px;
            min-width: 40px;
        }
    .input-field {
            width: 100%;
            padding: 10px;
            text-align: center;
        }

    table, th, td {
        border: 1px solid;
    }
</style>
@section('content')
<div class="container container_width" style="margin-top: 50px;"> 
    <div class="row" >
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12" style="margin: 20px">
                            @if(!$data[0]->isEmpty())
                                <!-- Book Start -->
                                <div class="container-xxl py-5">
                                    <div class="container">
                                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                            <h6 class="section-title bg-white text-center text-primary px-3">Koleksi</h6>
                                            <h1 class="mb-5">Rekomendasi Buku</h1>
                                            {{-- <div class="input-icons">
                                                <i class="fa fa-search icon"></i>
                                            <input type="text" class="input-field" id="search" name="search" placeholder="Cari Judul Buku" style="width:250px; height:40px;" >
                                            </div> --}}
                                        </div><br>
                                        <div class="row g-4" id="book_list">
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ( $data as $d)
                                                <a href="/detail-buku/{{$d[0]->id}}" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s" style="text-decoration: none">
                                                    <div class="team-item bg-light">
                                                        <div class="overflow-hidden">
                                                            <p style="color: black; text-decoration: none; float: left;">{{$i++}}</p>
                                                            <img class="img-fluid" src="{{asset('images/'.$d[0]->image)}}" id="cover-book">
                                                        </div>
                                                        <div class="text-center p-4">
                                                            <h5 class="mb-0">{{$d[0]->title}}</h5>
                                                            <small style="color: black; text-decoration: none;">Direkomendasikan {{number_format($arr_topsis[$d[0]->id], 4, '.', '') *100}} %</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Book End -->
                            @else
                                <h2 style="text-align: center">Tidak Ada data buku</h2>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Hasil angka TOPSIS --}}
                <div class="row">
                    <div class="col-sm-12" style="margin: 20px">
                        <h2>Hasil Angka Topsis</h2>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                    Langkah 1 - Membentuk Decision Matrix
                                </button>
                              </h2>
                              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{$arr_count_borrow[$bk->id]->count}}</td>
                                                    <td>{{$arr_count_page[$bk->id]->page}}</td>
                                                    <td>{{$arr_author[$bk->id]}}</td>
                                                    <td>{{$arr_age[$bk->id]->age}}</td>
                                                    <td>{{$arr_stock[$bk->id]->stock}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Langkah 2 - Membentuk Matrix R
                                </button>
                              </h2>
                              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <h4>Kuadratkan setiap nilai pada decision matrix</h4>
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{$pow_count_borrow[$bk->id]}}</td>
                                                    <td>{{$pow_count_page[$bk->id]}}</td>
                                                    <td>{{$pow_author[$bk->id]}}</td>
                                                    <td>{{$pow_age[$bk->id]}}</td>
                                                    <td>{{$pow_stock[$bk->id]}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th>Total</th>
                                                <td></td>
                                                <td>{{$k1}}</td>
                                                <td>{{$k2}}</td>
                                                <td>{{$k3}}</td>
                                                <td>{{$k4}}</td>
                                                <td>{{$k5}}</td>
                                            </tr>
                                            <tr>
                                                <th>Akar</th>
                                                <td></td>
                                                <td>{{number_format($sqrt_k1, 4, '.', '')}}</td>
                                                <td>{{number_format($sqrt_k2, 4, '.', '')}}</td>
                                                <td>{{number_format($sqrt_k3, 4, '.', '')}}</td>
                                                <td>{{number_format($sqrt_k4, 4, '.', '')}}</td>
                                                <td>{{number_format($sqrt_k5, 4, '.', '')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <h4>Bagi setiap nilai pada decision matrix dengan hasil akar setiap kriteria</h4>
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{number_format($matrix_r_k1[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_r_k2[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_r_k3[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_r_k4[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_r_k5[$bk->id], 4, '.', '')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>        
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    Langkah 3 - Membentuk Matrix V
                                </button>
                              </h2>
                              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <h4>Kalikan setiap nilai pada matrix R dengan bobot setiap kriteria</h4>
                                    <h6>Bobot K1 = {{$bobot_k1}}; Bobot K2 = {{$bobot_k2}}; Bobot K3 = {{$bobot_k3}}; Bobot K4 = {{$bobot_k4}}; Bobot K5 = {{$bobot_k5}}</h6>
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{number_format($matrix_v_k1[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_v_k2[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_v_k3[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_v_k4[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($matrix_v_k5[$bk->id], 4, '.', '')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                    Langkah 4 - Menentukan Solusi Ideal Positif (A*) dan Solusi Ideal Negatif (A')
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                                  <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <th></th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>A*</td>
                                                <td>{{number_format($solusi_ideal_positif_1, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_positif_2, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_positif_3, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_positif_4, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_positif_5, 4, '.', '')}}</td>
                                            </tr>
                                            <tr>
                                                <td>A'</td>
                                                <td>{{number_format($solusi_ideal_negatif_1, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_negatif_2, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_negatif_3, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_negatif_4, 4, '.', '')}}</td>
                                                <td>{{number_format($solusi_ideal_negatif_5, 4, '.', '')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                                    Langkah 5 - Menentukan jarak Solusi Ideal Positif (S*) dan jarak Solusi Ideal Negatif (S')
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
                                  <div class="accordion-body">
                                    <h2>Jarak Solusi Ideal Positif</h2>
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                            <th>S*</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_positif_1[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_positif_2[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_positif_3[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_positif_4[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_positif_5[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($jarak_solusi_ideal_positif[$bk->id], 4, '.', '')}}</td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    <h2>Jarak Solusi Ideal Negatif</h2>
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Buku</th>
                                            <th>Kriteria 1</th>
                                            <th>Kriteria 2</th>
                                            <th>Kriteria 3</th>
                                            <th>Kriteria 4</th>
                                            <th>Kriteria 5</th>
                                            <th>S'</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($book as $bk)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$bk->title}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_negatif_1[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_negatif_2[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_negatif_3[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_negatif_4[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($arr_jarak_solusi_ideal_negatif_5[$bk->id], 4, '.', '')}}</td>
                                                    <td>{{number_format($jarak_solusi_ideal_negatif[$bk->id], 4, '.', '')}}</td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                                    Langkah 6 - Menghitung nilai kedekatan relatif tiap alternatif (C)
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
                                  <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Gambar Sampul</th>
                                            <th>Buku</th>
                                            <th>Kedekatan relatif (C)</th>
                                            <th>Persen %</th>
                                            <th>Ranking</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($arr_topsis as $at => $val)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td><img class="img-fluid" src="{{asset('images/'.$data[$i-1][0]->image)}}" id="cover-book" width="150" height="250"></td>
                                                    <td>{{$data[$i-1][0]->title}}</td>
                                                    <td>{{number_format($val, 4, '.', '')}}</td>
                                                    <td>{{number_format($val, 4, '.', '') *100}} %</td>
                                                    <td>{{ $i++ }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection