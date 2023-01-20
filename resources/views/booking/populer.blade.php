@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Buku Yang Banyak Dipesan</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                  <div class="col-sm-12">
                    <div class="card-box table-responsive">
            <table id="custometable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul Buku</th>
                  <th>Cover</th>
                  <th>Penerbit</th>
                  <th>Penulis</th>
                  <th>Telah dipesan sebanyak</th>
                </tr>
              </thead>
              <tbody id="show_data">
              @php $no = 1; @endphp
                @foreach ($data as $bk)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td style="width:170px"><img class="img-fluid" src="{{asset('images/'.$bk->image)}}" id="cover-book" width="150" height="250"></td>
                    <td style="width: 20%">{{$bk->title}}</td>
                    <td style="width: 20%">{{$bk->publisher}}</td>
                    <td style="width: 20%">{{$bk->author}}</td>
                    <td>{{$bk->count}}</td>
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
@endsection