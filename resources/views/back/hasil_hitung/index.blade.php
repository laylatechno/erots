@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Catering Pro - {{ $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Tinggi Badan</th>
                                <th>Berat Badan</th>
                                <th>BB/U</th>
                                <th>TB/U</th>
                                <th>BB/TB</th>
                                <th>IMT</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($hasil_hitung as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->tanggal_lahir }}</td>
                                    <td>{{ $p->umur }}</td>
                                    <td>{{ $p->jenis_kelamin }}</td>
                                    <td>{{ $p->tinggi_badan }}</td>
                                    <td>{{ $p->berat_badan }}</td>
                                    <td>{{ $p->result_bb_u }}</td> <!-- BB/U -->
                                    <td>{{ $p->result_tb_u }}</td> <!-- TB/U -->
                                    <td>{{ $p->result_bb_tb }}</td> <!-- BB/TB -->
                                    <td>{{ $p->result_imt }}</td> <!-- IMT -->
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                            data-target="#modal-edit" data-id="{{ $p->id }}" style="color: black">
                                            <i class="fas fa-edit"></i> Detail
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}"
                                            style="color: white">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>



    {{-- Modal Edit Data --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form {{ $subtitle }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Main content -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->

                        <form id="form-edit" action="" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <!-- Input hidden untuk menyimpan ID -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="nama_edit_container">
                                            <label for="name">Nama Anak</label>
                                            <input type="text" class="form-control" name="nama" id="nama_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="tanggal_lahir_edit_container">
                                            <label for="tanggal_lahir_edit">Tanggal Lahir</label>
                                            <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir_edit">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="umur_edit_container">
                                            <label for="umur_edit">Umur</label>
                                            <input type="text" class="form-control" name="umur" id="umur_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="jenis_kelamin_edit_container">
                                            <label for="jenis_kelamin_edit">Jenis Kelamin</label>
                                            <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin_edit">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="berat_badan_edit_container">
                                            <label for="berat_badan_edit">Berat Badan</label>
                                            <input type="text" class="form-control" name="berat_badan" id="berat_badan_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="tinggi_badan_edit_container">
                                            <label for="tinggi_badan_edit">Tinggi Badan</label>
                                            <input type="text" class="form-control" name="tinggi_badan" id="tinggi_badan_edit">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="result_bb_u_edit_container">
                                            <label for="result_bb_u_edit">BB/U</label>
                                            <input type="text" class="form-control" name="result_bb_u" id="result_bb_u_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="result_tb_u_edit_container">
                                            <label for="result_tb_u_edit">TB/U</label>
                                            <input type="text" class="form-control" name="result_tb_u" id="result_tb_u_edit">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" id="result_bb_tb_edit_container">
                                            <label for="result_bb_tb_edit">BB/TB</label>
                                            <input type="text" class="form-control" name="result_bb_tb" id="result_bb_tb_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="result_imt_edit_container">
                                            <label for="result_imt_edit">IMT</label>
                                            <input type="text" class="form-control" name="result_imt" id="result_imt_edit">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- /.card-body -->

                               
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>






@endsection




@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- PERINTAH EDIT DATA --}}
    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '/hasil_hitung/' + id + '/edit',
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#nama_edit').val(data.nama);
                        $('#tanggal_lahir_edit').val(data.tanggal_lahir);
                        $('#umur_edit').val(data.umur);
                        $('#jenis_kelamin_edit').val(data.jenis_kelamin);
                        $('#berat_badan_edit').val(data.berat_badan);
                        $('#tinggi_badan_edit').val(data.tinggi_badan);
                        $('#result_bb_u_edit').val(data.result_bb_u);
                        $('#result_tb_u_edit').val(data.result_tb_u);
                        $('#result_bb_tb_edit').val(data.result_bb_tb);
                        $('#result_imt_edit').val(data.result_imt);
                        $('#modal-edit').modal('show');
                    },
                    error: function(xhr) {
                        // Tangani kesalahan jika ada
                        alert('Error: ' + xhr.statusText);
                    }
                });
            });


        });
    </script>
    {{-- PERINTAH EDIT DATA --}}


    {{-- PERINTAH DELETE DATA --}}
    <script>
        $(document).ready(function() {
            $('.dataTable tbody').on('click', 'td .btn-hapus', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah yakin akan menghapus data ?',
                    text: "data tidak bisa dikembalikan jika sudah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan permintaan AJAX ke endpoint penghapusan
                        $.ajax({
                            url: '/hasil_hitung/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('message') && response
                                    .message.includes(
                                        'terkait dengan mutasi_surat-keluar')) {
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.hasOwnProperty('message') &&
                                    response.message === 'Data Berhasil Dihapus') {
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed || result
                                            .isDismissed) {
                                            location
                                                .reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message ||
                                            'Gagal menghapus data',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data/masih terkait dengan tabel lain',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                console.log(xhr
                                    .responseText
                                ); // Tampilkan pesan error jika terjadi
                            }
                        });
                    }
                });
            });
        });
    </script>
    {{-- PERINTAH DELETE DATA --}}
@endpush
