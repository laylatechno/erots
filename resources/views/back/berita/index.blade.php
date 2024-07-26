@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $profil->nama_perusahaan }} - {{ $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i
                            class="fas fa-plus-circle"></i> Tambah Data</a>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori Berita</th>
                                <th>Judul Berita</th>
                                <th>Tanggal Posting</th>
                                <th>Status</th>
                                <th width="10%">Gambar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            @foreach ($berita as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->kategoriBerita->nama_kategori_berita }}</td>
                                    <td>{{ $p->judul_berita }}</td>
                                    <td>{{ $p->tanggal_posting }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td><a href="/upload/berita/{{ $p->gambar }}" target="_blank"><img
                                                style="max-width:100px; max-height:100px"
                                                src="/upload/berita/{{ $p->gambar }}" alt=""></a></td>
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
        <div class="modal-dialog modal-xl">
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
                                        <div class="form-group">
                                            <label for="tanggal_posting">Tanggal Posting</label>
                                            <input type="date" class="form-control" id="tanggal_posting"
                                                name="tanggal_posting" required>
                                        </div>
                                    </div>
                                    <script>
                                        // Dapatkan elemen input tanggal
                                        const inputTanggal = document.getElementById('tanggal_posting');

                                        // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                                        const today = new Date().toISOString().split('T')[0];

                                        // Set nilai default input tanggal menjadi tanggal hari ini
                                        inputTanggal.value = today;
                                    </script>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="judul_berita">Judul Berita</label>
                                            <input type="text" class="form-control" id="judul_berita" name="judul_berita"
                                                placeholder="Masukkan Judul Berita" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="penulis">Penulis</label>
                                            <input type="text" class="form-control" id="penulis" name="penulis"
                                                placeholder="Masukkan Penulis Berita" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_berita_id">Kategori</label>
                                            <select class="form-control select2" name="kategori_berita_id"
                                                id="kategori_berita_id" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriBerita as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_berita }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ringkasan">Ringkasan</label>
                                            <input type="text" class="form-control" id="ringkasan" name="ringkasan"
                                                placeholder="Masukkan Ringkasan">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="isi">Isi</label>
                                            <textarea name="isi" id="isi" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="gambar">Gambar Berita</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar"
                                                onchange="previewImage()">
                                            <canvas id="preview_canvas"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                        <script>
                                            function previewImage() {
                                                var previewCanvas = document.getElementById('preview_canvas');
                                                var previewImage = document.getElementById('preview_image');
                                                var fileInput = document.getElementById('gambar');
                                                var file = fileInput.files[0];
                                                var reader = new FileReader();

                                                reader.onload = function(e) {
                                                    var img = new Image();
                                                    img.src = e.target.result;

                                                    img.onload = function() {
                                                        var canvasContext = previewCanvas.getContext('2d');
                                                        var maxWidth = 200; // Max width untuk pratinja gambar

                                                        var scaleFactor = maxWidth / img.width;
                                                        var newHeight = img.height * scaleFactor;

                                                        previewCanvas.width = maxWidth;
                                                        previewCanvas.height = newHeight;

                                                        canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                        // Menampilkan pratinja gambar setelah diperkecil
                                                        previewCanvas.style.display = 'block';
                                                        previewImage.style.display = 'none';
                                                    };
                                                };

                                                if (file) {
                                                    reader.readAsDataURL(file); // Membaca file yang dipilih sebagai URL data
                                                } else {
                                                    previewImage.src = '';
                                                    previewCanvas.style.display = 'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                                }
                                            }
                                        </script>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="sumber">Sumber</label>
                                            <input type="text" class="form-control" id="sumber" name="sumber"
                                                placeholder="Masukkan Sumber">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="urutan">Urutan</label>
                                            <input type="number" class="form-control" id="urutan" name="urutan"
                                                placeholder="Masukkan Urutan">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="status_container">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Non Aktif"
                                                    {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>
                                                    Non Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

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
        <div class="modal-dialog modal-xl">
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
                                        <div class="form-group">
                                            <label for="tanggal_posting_edit">Tanggal Posting</label>
                                            <input type="date" class="form-control" id="tanggal_posting_edit"
                                                name="tanggal_posting" required>
                                        </div>
                                    </div>
                                    <script>
                                        // Dapatkan elemen input tanggal
                                        const inputTanggal = document.getElementById('tanggal_posting_edit');

                                        // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                                        const today = new Date().toISOString().split('T')[0];

                                        // Set nilai default input tanggal menjadi tanggal hari ini
                                        inputTanggal.value = today;
                                    </script>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="judul_berita_edit">Judul Berita</label>
                                            <input type="text" class="form-control" id="judul_berita_edit" name="judul_berita"
                                                placeholder="Masukkan Judul Berita" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" class="form-control" id="slug_edit" name="slug"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="penulis_edit">Penulis</label>
                                            <input type="text" class="form-control" id="penulis_edit" name="penulis"
                                                placeholder="Masukkan Penulis Berita" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_berita_id_edit">Kategori</label>
                                            <select class="form-control select2" name="kategori_berita_id"
                                                id="kategori_berita_id_edit" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriBerita as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_berita }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ringkasan_edit">Ringkasan</label>
                                            <input type="text" class="form-control" id="ringkasan_edit" name="ringkasan"
                                                placeholder="Masukkan Ringkasan">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="isi_edit">Isi</label>
                                            <textarea name="isi" id="isi_edit" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="gambar_edit_container">
                                            <label for="gambar_edit">Gambar</label>
                                            <br>
                                            <input type="file" class="form-control" name="gambar" id="gambar_edit"
                                                onchange="previewImage_edit()">

                                            <canvas id="preview_canvas_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_edit" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                            <br>
                                        </div>
                                        <script>
                                            function previewImage_edit() {
                                                var previewCanvas_edit = document.getElementById('preview_canvas_edit');
                                                var previewImage_edit = document.getElementById('preview_image_edit');
                                                var fileInput_edit = document.getElementById('gambar_edit'); // Mengubah id menjadi gambar_edit
                                                var file_edit = fileInput_edit.files[0];
                                                var reader_edit = new FileReader();
    
                                                reader_edit.onload = function(e) {
                                                    var img = new Image();
                                                    img.src = e.target.result;
    
                                                    img.onload = function() {
                                                        var canvasContext = previewCanvas_edit.getContext('2d');
                                                        var maxWidth = 200; // Max width untuk pratinja gambar
    
                                                        var scaleFactor = maxWidth / img.width;
                                                        var newHeight = img.height * scaleFactor;
    
                                                        previewCanvas_edit.width = maxWidth;
                                                        previewCanvas_edit.height = newHeight;
    
                                                        canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);
    
                                                        // Menampilkan pratinja gambar setelah diperkecil
                                                        previewCanvas_edit.style.display = 'block';
                                                        previewImage_edit.style.display = 'none';
                                                    };
                                                };
    
                                                if (file_edit) {
                                                    reader_edit.readAsDataURL(file_edit); // Membaca file yang dipilih sebagai URL data
                                                } else {
                                                    previewImage_edit.src = '';
                                                    previewCanvas_edit.style.display =
                                                        'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                                }
                                            }
                                        </script>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="sumber_edit">Sumber</label>
                                            <input type="text" class="form-control" id="sumber_edit" name="sumber"
                                                placeholder="Masukkan Sumber">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="urutan_edit">Urutan</label>
                                            <input type="number" class="form-control" id="urutan_edit" name="urutan"
                                                placeholder="Masukkan Urutan">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="status_edit_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Non Aktif"
                                                    {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>
                                                    Non Aktif
                                                </option>
                                            </select>
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


@push('css')
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/select2/css/custom.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Memuat skrip JavaScript Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="{{ asset('themplete/back') }}/plugins/summernote/summernote-bs4.min.js"></script>

    {{-- Summernote --}}
    <script>
        $(function() {
            // Summernote
            $('#isi').summernote({
                height: 200
            });


        })
    </script>
    {{-- Summernote --}}



    <script>
        $(function() {
            // Inisialisasi Summernote
            $('#isi_edit').summernote({
                height: 200,
                callbacks: {
                    // Fungsi setelah Summernote selesai dimuat
                    onInit: function() {
                        // Set nilai pada Summernote
                        $('#isi_edit').summernote('code', data.isi_edit);
                    }
                }
            });
        });
    </script>




    <!-- Inisialisasi Select2 -->
    <script>
        $(document).ready(function() {
            $('#kategori_berita_id').select2();
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>

    {{-- perintah slug tambah data --}}
    <script>
        $(document).ready(function() {
            $('#judul_berita').on('input', function() {
                var slug = $(this).val().toLowerCase().replace(/\s+/g, '-');
                $('#slug').val(slug);
            });
        });
    </script>

    {{-- perintah slug tambah data --}}

    {{-- perintah slug edit data --}}
    <script>
        $(document).ready(function() {
            $('#judul_berita_edit').on('input', function() {
                var slug = $(this).val().toLowerCase().replace(/\s+/g, '-');
                $('#slug_edit').val(slug);
            });
        });
    </script>

    {{-- perintah slug edit data --}}

    {{-- PERINTAH SIMPAN DATA --}}
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('berita.store') }}',
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
                    url: '/berita/' + id + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id) // Menambahkan nilai id ke input tersembunyi
                        $('#tanggal_posting_edit').val(data.tanggal_posting);
                        $('#judul_berita_edit').val(data.judul_berita);
                        $('#slug_edit').val(data.slug);
                        $('#penulis_edit').val(data.penulis);
                        $('#kategori_berita_id_edit').val(data.kategori_berita_id);
                        $('#ringkasan_edit').val(data.ringkasan);
                        $('#sumber_edit').val(data.sumber);
                        $('#urutan_edit').val(data.urutan);
                        $('#status_edit').val(data.status);
                        // $('#isi_edit').val(data.isi);
                        $('#isi_edit').summernote('code', data.isi);

                         // Hapus gambar yang ada sebelum menambahkan gambar yang baru
                        $('#gambar_edit_container img').remove();
                        $('#gambar_edit_container a').remove();

                        // Tambahkan logika untuk menampilkan gambar bukti pada formulir edit
                        if (data.gambar) {
                            var gambarImg = '<img src="/upload/berita/' + data.gambar +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var gambarLink = '<a href="/upload/berita/' + data.gambar +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#gambar_edit_container').append(gambarImg + '<br>' +
                                gambarLink);
                        }

                        $('#modal-edit').modal('show');
                        $('#id').val(id);
                    },
                    error: function(xhr) {
                        // Tangani kesalahan jika ada
                        alert('Error: ' + xhr.statusText);
                    }
                });
            });

            // Mengosongkan gambar saat modal ditutup
            $('#modal-edit').on('hidden.bs.modal', function() {
                $('#gambar_edit_container img').remove();
                $('#gambar_edit_container a').remove();
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
                    url: '/berita/' + id,
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
                            url: '/berita/' + id,
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
