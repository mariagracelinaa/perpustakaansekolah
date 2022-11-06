@extends('layouts.gentelella')

@section('content')
<h2>Detail Pengguna</h2>
    <input type="hidden" id="allow_borrow" value="{{ $allow}}">
    <table>
        <tbody>
            <tr>
                <td>Nama </td>
                <td> : {{$user[0]->name}}</td>
            </tr>
            <tr>
                <td>Kelas/Jabatan </td>
                <td> : 
                    @if($user[0]->class != null)
                        {{$user[0]->class}}
                    @else
                        Guru/Staf
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                   Nomor Registrasi Buku 
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="container" style="min-height: 100vh">  
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tambah Peminjaman</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button onclick="addCirculation()" class="btn btn-primary"><i class="fa fa-plus"></i> Simpan Peminjaman</button>
                        </ul>
                        <div class="clearfix">
                            {{--  --}}
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input id="reg_num">
                                                </td>
                                                <td>
                                                    <a class="btn btn-light" name="add" id="add"><i class="fa fa-plus"></i> Tambah Buku</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <form id="add_circulation">
                                        @csrf
                                        <input type="hidden" name="users_id" value="{{$user[0]->users_id}}">
                                        <table class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nomor registrasi buku</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                </thead>
                                                <tbody id="dynamic_field">
                                                    
                                                </tbody>
                                        </table>
                                    </form>
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
<script type="text/javascript">
    $(document).ready(function(){
        var i=1; 
        var count = 1;
        var allow = $('#allow_borrow').val();
        $('#add').click(function(){ 
            var reg_num=$('#reg_num').val();
            // ke db cek reg_num sedang dipinjam atau tidak, kalau tidak bisa ditambah di list
            $.ajax({
                type:'POST',
                url:'{{url("/check-sebelum-tambah")}}',
                data:{
                        '_token': '<?php echo csrf_token() ?>',
                        'reg_num': reg_num
                    },
                success:function(data) {
                    // location.reload();
                    // jika tidak ada di daftar peminjaman berjalan maka tampilkan listBook
                    if(data.count == 0){
                        // alert('muncul listBook');
                        if(count <= allow){
                            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="hidden" name="listBook[]" value="'+reg_num+'">'+ reg_num +'</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>'); 
                            i++;
                            count++;
                        }
                    }else{
                        alert('Buku ada di daftar peminjaman yang sedang berjalan');
                    }
                }
            });
        }); 
        
        $(document).on('click', '.btn_remove', function(){    
            var button_id = $(this).attr("id");     
            $('#row'+button_id+'').remove();
            count = count-1;
        }); 
    });

    function addCirculation(){
    var formData = new FormData($("#add_circulation")[0]);
        $.ajax({
            url: '{{route("daftar-peminjaman.store")}}',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success:function(data) {
                location.reload();
            }
        }); 
    }
</script>
@endsection