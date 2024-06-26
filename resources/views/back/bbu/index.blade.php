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
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i
                            class="fas fa-plus-circle"></i> Tambah Data</a>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Min 3 SD</th>
                                <th>Min 2 SD</th>
                                <th>Min 1 SD</th>
                                <th>Median</th>
                                <th>Max 1 SD</th>
                                <th>Max 2 SD</th>
                                <th>Max 3 SD</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            @foreach ($bbu as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->umur }}</td>
                                    <td>{{ $p->jenis_kelamin }}</td>
                                    <td>{{ $p->min_3_sd }}</td>
                                    <td>{{ $p->min_2_sd }}</td>
                                    <td>{{ $p->min_3_sd }}</td>
                                    <td>{{ $p->median }}</td>
                                    <td>{{ $p->max_1_sd }}</td>
                                    <td>{{ $p->max_2_sd }}</td>
                                    <td>{{ $p->max_3_sd }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                            data-target="#modal-edit" data-id="{{ $p->id }}" style="color: black">
                                            <i class="fas fa-edit"></i> Edit
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



    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="modal-tambah">
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

                        <!-- form start -->
                        <form id="form-tambah" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group" id="umur_container">
                                            <label for="umur">Umur</label>
                                            <input type="number" class="form-control" name="umur" id="umur">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-6">
                                        <div class="form-group" id="jenis_kelamin_container">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                                <option value="">--Pilih Jenis Kelamin--</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group" id="min_3_sd_container">
                                            <label for="min_3_sd">Min 3 SD</label>
                                            <input type="number" class="form-control" name="min_3_sd" id="min_3_sd" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="min_2_sd_container">
                                            <label for="min_2_sd">Min 2 SD</label>
                                            <input type="number" class="form-control" name="min_2_sd" id="min_2_sd" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="min_1_sd_container">
                                            <label for="min_1_sd">Min 1 SD</label>
                                            <input type="number" class="form-control" name="min_1_sd" id="min_1_sd" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="median_container">
                                            <label for="median">Median</label>
                                            <input type="number" class="form-control" name="median" id="median" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_1_sd_container">
                                            <label for="max_1_sd">Max 1 SD</label>
                                            <input type="number" class="form-control" name="max_1_sd" id="max_1_sd" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_2_sd_container">
                                            <label for="max_2_sd">Max 2 SD</label>
                                            <input type="number" class="form-control" name="max_2_sd" id="max_2_sd" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_3_sd_container">
                                            <label for="max_3_sd">Max 3 SD</label>
                                            <input type="number" class="form-control" name="max_3_sd" id="max_3_sd" step="0.1">
                                        </div>
                                    </div>
                                    
                                   




                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-tambah"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
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
                                        <div class="form-group" id="umur_edit_container">
                                            <label for="umur_edit">Umur</label>
                                            <input type="number" class="form-control" name="umur" id="umur_edit">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-6">
                                        <div class="form-group" id="jenis_kelamin_edit_container">
                                            <label for="jenis_kelamin_edit">Jenis Kelamin</label>
                                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin_edit">
                                                <option value="">--Pilih Jenis Kelamin--</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group" id="min_3_sd_edit_container">
                                            <label for="min_3_sd_edit">Min 3 SD</label>
                                            <input type="number" class="form-control" name="min_3_sd" id="min_3_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="min_2_sd_edit_container">
                                            <label for="min_2_sd_edit">Min 2 SD</label>
                                            <input type="number" class="form-control" name="min_2_sd" id="min_2_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="min_1_sd_edit_container">
                                            <label for="min_1_sd_edit">Min 1 SD</label>
                                            <input type="number" class="form-control" name="min_1_sd" id="min_1_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="median_edit_container">
                                            <label for="median_edit">Median</label>
                                            <input type="number" class="form-control" name="median" id="median_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_1_sd_edit_container">
                                            <label for="max_1_sd_edit">Max 1 SD</label>
                                            <input type="number" class="form-control" name="max_1_sd" id="max_1_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_2_sd_edit_container">
                                            <label for="max_2_sd_edit">Max 2 SD</label>
                                            <input type="number" class="form-control" name="max_2_sd" id="max_2_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="max_3_sd_edit_container">
                                            <label for="max_3_sd_edit">Max 3 SD</label>
                                            <input type="number" class="form-control" name="max_3_sd" id="max_3_sd_edit" step="0.1">
                                        </div>
                                    </div>
                                    




                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-edit"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
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
    {{-- PERINTAH SIMPAN DATA --}}
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('bbu.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, // Menghindari jQuery memproses data
                    contentType: false, // Menghindari jQuery mengatur Content-Type
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        tombolSimpan.prop('disabled', true)
                    },
                    success: function(response) {
                        $('#modal-tambah').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil disimpan',
                            icon: 'success',
                            html: '<br>Data berhasil disimpan', // Tambahkan subjudul di sini
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location.reload();
                        });
                    },

                    complete: function() {
                        tombolSimpan.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            $('#modal-tambah').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    {{-- PERINTAH SIMPAN DATA --}}

    {{-- PERINTAH EDIT DATA --}}
    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '/bbu/' + id + '/edit',
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#umur_edit').val(data.umur);
                        $('#jenis_kelamin_edit').val(data.jenis_kelamin);
                        $('#min_3_sd_edit').val(data.min_3_sd);
                        $('#min_2_sd_edit').val(data.min_2_sd);
                        $('#min_1_sd_edit').val(data.min_1_sd);
                        $('#median_edit').val(data.median);
                        $('#max_1_sd_edit').val(data.max_1_sd);
                        $('#max_2_sd_edit').val(data.max_2_sd);
                        $('#max_3_sd_edit').val(data.max_3_sd);
                        $('#modal-edit').modal('show');
                        $('#id').val(id);
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



    {{-- PERINTAH UPDATE DATA --}}
    <script>
        $(document).ready(function() {
            $('#btn-save-edit').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-save-edit');
                var id = $('#id').val();
                var formData = new FormData($('#form-edit')[0]);

                $.ajax({
                    type: 'POST', // Gunakan POST karena kita override dengan PUT
                    url: '/bbu/' + id,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove();
                        tombolUpdate.prop('disabled', true);
                    },
                    success: function(response) {
                        $('#modal-edit').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    },
                    complete: function() {
                        tombolUpdate.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            $('#modal-edit').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

    {{-- PERINTAH UPDATE DATA --}}

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
                            url: '/bbu/' + id,
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
