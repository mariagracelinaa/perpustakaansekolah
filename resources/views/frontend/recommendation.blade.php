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
                                            @foreach ( $data as $d)
                                                <a href="/detail-buku/{{$d[0]->id}}" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                                    <div class="team-item bg-light">
                                                        <div class="overflow-hidden">
                                                            <img class="img-fluid" src="{{asset('images/'.$d[0]->image)}}" id="cover-book">
                                                        </div>
                                                        <div class="text-center p-4">
                                                            <h5 class="mb-0">{{$d[0]->title}}</h5>
                                                            {{-- <small>Penulis</small> --}}
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
                        <h3>Langkah 0 - Membentuk Decision Matrix</h3>
                        <table class="table">
                            <thead>
                                <th>Judul Buku</th>
                                <th>Kriteria 1</th>
                                <th>Kriteria 2</th>
                                <th>Kriteria 3</th>
                                <th>Kriteria 4</th>
                                <th>Kriteria 5</th>
                            </thead>
                            <tbody>
                                @foreach ($book as $bk)
                                    <tr>
                                        <td>{{$bk->title}}</td>
                                        <td>{{$arr_count_borrow[$bk->id]->count}}</td>
                                        <td>{{$arr_count_page[$bk->id]->page}}</td>
                                        <td>{{$arr_publish_year[$bk->id]->publish_year}}</td>
                                        <td>{{$arr_age[$bk->id]->age}}</td>
                                        <td>{{$arr_stock[$bk->id]->stock}}</td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>

                        <h3>Langkah 1 - Membentuk Matrix R</h3>
                        <h4>Kuadratkan setiap nilai pada decision matrix</h4>
                        <table class="table">
                            <thead>
                                <th>Judul Buku</th>
                                <th>Kriteria 1</th>
                                <th>Kriteria 2</th>
                                <th>Kriteria 3</th>
                                <th>Kriteria 4</th>
                                <th>Kriteria 5</th>
                            </thead>
                            <tbody>
                                @foreach ($book as $bk)
                                    <tr>
                                        <td>{{$bk->title}}</td>
                                        <td>{{$pow_count_borrow[$bk->id]}}</td>
                                        <td>{{$pow_count_page[$bk->id]}}</td>
                                        <td>{{$pow_publish_year[$bk->id]}}</td>
                                        <td>{{$pow_age[$bk->id]}}</td>
                                        <td>{{$pow_stock[$bk->id]}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total</th>
                                    <td>{{$k1}}</td>
                                    <td>{{$k2}}</td>
                                    <td>{{$k3}}</td>
                                    <td>{{$k4}}</td>
                                    <td>{{$k5}}</td>
                                </tr>
                                <tr>
                                    <th>Akar</th>
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
                                <th>Judul Buku</th>
                                <th>Kriteria 1</th>
                                <th>Kriteria 2</th>
                                <th>Kriteria 3</th>
                                <th>Kriteria 4</th>
                                <th>Kriteria 5</th>
                            </thead>
                            <tbody>
                                @foreach ($book as $bk)
                                    <tr>
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

                        <h3>Langkah 3 - Menentukan Solusi Ideal Positif (A*) dan Solusi Ideal Negatif (A')</h3>
                        <table class="table">
                            <thead>
                                <<th></th>
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
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection