@extends('layouts.gentelella')

@section('content')
<div class="container" style="min-height: 100vh">
  <div>
    <form action="{{url('/sirkulasi-buku-filter')}}">
      <label>Filter Data Berdasarkan</label><br>
      <select name="filter" id="filter" class="form-control">
        @if ($filter == "")
          <option value="" selected>-- Pilih Kriteria --</option>
        @else
          <option value="">-- Pilih Kriteria --</option>
        @endif

        @if ($filter == 'role')
          <option value="role" selected>Kelas/Jabatan</option>
        @else
          <option value="role">Kelas/Jabatan</option>
        @endif
      </select>
      <br>
      <label>Kelas/Jabatan</label>
      <select name="role" id="role" class="form-control" disabled>
          @if ($role == "")
              <option value="" selected>-- Pilih Kelas/Jabatan --</option>
          @else
              <option value="">-- Pilih Kelas/Jabatan --</option>
          @endif
          
          @if ($role == 'guru/staf')
            <option value="guru/staf" selected>Guru/Staf</option>
          @else
            <option value="guru/staf">Guru/Staf</option>
          @endif

          @if ($role == 'murid')
            <option value="murid" selected>Murid</option>
          @else
            <option value="murid">Murid</option>
          @endif

          @foreach ($class as $c)
            @if ($role == $c->id)
                <option value="{{$c->id}}" selected>Kelas {{$c->name}}</option>
            @else
                <option value="{{$c->id}}">Kelas {{$c->name}}</option>
            @endif
          @endforeach
      </select><br>
      <input type="submit" value="Tampilkan Data" id="btn_show" class="btn btn-primary" disabled>
    </form>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sirkulasi Buku Perpustakaan - Daftar Pengguna Perpustakaan</small></h2>
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
                  <th>NISN/NIY</th>
                  <th>Nama</th>
                  <th>Kelas/Jabatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="show_data">
              @php $no = 1; @endphp
                @foreach ($data as $d)
                  <tr>
                    <td style="width: 5%;">{{ $no++ }}</td>
                    <td>
                        @if($d->role = 'murid')
                            {{$d->nisn}}
                        @endif
                        
                        @if($d->role = 'guru/staf')
                            {{$d->niy}}
                        @endif
                    </td>
                    <td>
                        {{$d->name}}
                    </td>
                    <td>
                        @if($d->class != null)
                            {{$d->class}}
                        @else
                            Guru/Staf
                        @endif
                    </td>
                    <td style="width: 10%;">
                        <ul class="nav navbar-right panel_toolbox">
                          <a class="btn btn-primary" href="sirkulasi-detail/{{$d->id}}"><i class="fa fa-info-circle"></i> Detail</a>    
                        </ul>
                    </td>
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

@section('javascript')
<script>
    $( document ).ready(function() {
      if($("#filter").val() == "role"){
        $("#role").removeAttr("disabled");
        $("#btn_show").removeAttr("disabled");
      }else{
        $("#btn_show").attr('disabled', 'disabled');
        $("#role").attr('disabled', 'disabled');

        $("#role").val('');
      }  
    });

    $("#filter").change(function () {
      if($("#filter").val() == "role"){
        $("#role").removeAttr("disabled");
        $("#btn_show").removeAttr("disabled");
      }else{
        $("#btn_show").attr('disabled', 'disabled');
        $("#role").attr('disabled', 'disabled');

        $("#role").val('');
      }
    });
</script>
@endsection