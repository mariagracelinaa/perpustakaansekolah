<div class="modal-header">
    <button type="button" class="close" 
      data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Detail Transaksi Peminjaman</h4>
</div>
<div style="padding: 20px;">
    <table class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nomor Registrasi</th>
            <th>Tanggal Kembali</th>
            <th>Denda</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
          @foreach ($data as $bt)
            <tr>
                <td style="width: 5%;">{{ $no++ }}</td>
                <td>{{$bt->register_num}}</td>
                <td>
                    @if ($bt->return_date != null)
                        {{$bt->return_date}}
                    @else
                        -
                    @endif
                    
                </td>
                <td style="text-align: right">{{number_format($bt->fine)}}</td>
                <td>
                    @if($bt->status == 'belum kembali')
                        Belum Kembali
                    @elseif($bt->status == 'sudah kembali')
                        Sudah Kembali
                    @endif
                </td>
            </tr>
          @endforeach
        </tbody>
    </table>
</div>
