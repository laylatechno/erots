@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
<style>
    /* Ensure images don't exceed the cell size */
    table.dataTable tbody td img {
        max-width: 100%;
        height: auto;
    }

    /* Adjust the table to fit within smaller screens */
    table.dataTable {
        width: 100% !important;
    }

    /* Additional styling for table headers to avoid wrapping */
    table.dataTable thead th {
        white-space: nowrap;
    }
</style>
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

                    <table id="produkTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-priority="1">No</th>
                                <th data-priority="2">Nama Produk</th>
                                <th data-priority="4">Kategori</th>
                                <th data-priority="5">Status</th>
                                <th data-priority="3">User</th>
                                <th data-priority="6">Gambar</th>
                                <th data-priority="7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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

                                    @if ($isAdmin)
                                        <div class="col-12">
                                            <div class="form-group" id="user_id_container">
                                                <label for="user_id">Nama User</label>
                                                <select name="user_id" id="user_id" class="form-control select2">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-6">
                                        <div class="form-group" id="nama_produk_container">
                                            <label for="nama_produk">Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_produk" id="nama_produk"
                                                placeholder="Nama Produk">
                                        </div>
                                    </div>
                                    <div class="col-12" hidden>
                                        <div class="form-group" id="slug_container">
                                            <label for="slug">Slug Produk</label>
                                            <input type="text" class="form-control" name="slug" id="slug">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_produk_id">Kategori</label>
                                            <select class="form-control select2" name="kategori_produk_id"
                                                id="kategori_produk_id" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriProduk as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_beli_container">
                                            <label for="harga_beli">Harga Beli</label>
                                            <input type="text" class="form-control " name="harga_beli" id="harga_beli"
                                                placeholder="Harga Beli">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_jual_container">
                                            <label for="harga_jual">Harga Jual</label>
                                            <input type="text" class="form-control " name="harga_jual" id="harga_jual"
                                                placeholder="Harga Jual">
                                        </div>
                                    </div>

                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                    <script>
                                        $(document).ready(function() {
                                            // Event handler saat input berubah pada input harga_beli dan harga_jual
                                            $('#harga_beli, #harga_jual, #harga_jual_diskon').on('input', function(e) {
                                                var inputVal = $(this).val().replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
                                                var formattedVal = addThousandSeparator(inputVal);
                                                $(this).val(formattedVal);
                                            });

                                            // Fungsi untuk menambahkan separator ribuan
                                            function addThousandSeparator(num) {
                                                var parts = num.toString().split(".");
                                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                return parts.join(".");
                                            }
                                        });
                                    </script>

                                    <div class="col-12">
                                        <div class="form-group" id="deskripsi_container">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="stok_container">
                                            <label for="stok">Stok</label>
                                            <input type="number" class="form-control" name="stok" id="stok"
                                                placeholder="Stok">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="gambar_container">
                                            <label for="gambar">Gambar</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar"
                                                onchange="previewImage()">
                                            <canvas id="preview_canvas"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
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

                                    <div class="col-6">
                                        <div class="form-group" id="status_container">
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

                                    <div class="col-6">
                                        <div class="form-group" id="status_diskon_container">
                                            <label for="status_diskon_edit">Status Diskon</label>
                                            <select class="form-control" name="status_diskon" id="status_diskon_edit">
                                                <option value="">--Pilih Status Diskon--</option>
                                                <option value="Aktif"
                                                    {{ old('status_diskon') == 'Aktif' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="Non Aktif"
                                                    {{ old('status_diskon') == 'Non Aktif' ? 'selected' : '' }}>
                                                    Non Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="harga_jual_diskon_container">
                                            <label for="harga_jual_diskon">Harga Jual Diskon</label>
                                            <input type="text" class="form-control" name="harga_jual_diskon"
                                                id="harga_jual_diskon" placeholder="Harga Jual Diskon">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="youtube_container">
                                            <label for="youtube">Embed Youtube</label>
                                            <input type="text" class="form-control" name="youtube"
                                                id="youtube" placeholder="Embed Youtube">
                                        </div>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            // Event handler saat input berubah pada input harga_beli dan harga_jual
                                            $('#harga_beli, #harga_jual, #harga_jual_diskon').on('input', function(e) {
                                                var inputVal = $(this).val().replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
                                                var formattedVal = addThousandSeparator(inputVal);
                                                $(this).val(formattedVal);
                                            });

                                            // Fungsi untuk menambahkan separator ribuan
                                            function addThousandSeparator(num) {
                                                var parts = num.toString().split(".");
                                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                return parts.join(".");
                                            }
                                        });
                                    </script>

                                    @if ($isAdmin)
                                        <div class="col-12">
                                            <div class="form-group" id="urutan_container">
                                                <label for="urutan">Urutan</label>
                                                <input type="number" class="form-control" name="urutan" id="urutan"
                                                    placeholder="Urutan">
                                            </div>
                                        </div>
                                    @endif




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

                        <form id="form-edit" action="" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <!-- Input hidden untuk menyimpan ID -->
                            <div class="card-body">

                                <div class="row">
                                    @if ($isAdmin)
                                        <div class="col-12">
                                            <div class="form-group" id="user_id_edit_container">
                                                <label for="user_id_edit">Nama User</label>
                                                <select name="user_id" id="user_id_edit" class="form-control select2">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-6">
                                        <div class="form-group" id="nama_produk_edit_container">
                                            <label for="nama_produk_edit">Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_produk"
                                                id="nama_produk_edit" placeholder="Nama Produk">
                                        </div>
                                    </div>
                                    <div class="col-12" hidden>
                                        <div class="form-group" id="slug_edit_container">
                                            <label for="slug_edit">Slug Produk</label>
                                            <input type="text" class="form-control" name="slug" id="slug_edit">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="kategori_produk_id_edit">Kategori</label>
                                            <select class="form-control select2" name="kategori_produk_id"
                                                id="kategori_produk_id_edit" required>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($kategoriProduk as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->nama_kategori_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_beli__edit_container">
                                            <label for="harga_beli_edit">Harga Beli</label>
                                            <input type="text" class="form-control" name="harga_beli"
                                                id="harga_beli_edit" placeholder="Harga Beli">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="harga_jual__edit_container">
                                            <label for="harga_jual_edit">Harga Jual</label>
                                            <input type="text" class="form-control" name="harga_jual"
                                                id="harga_jual_edit" placeholder="Harga Jual">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="deskripsi_edit_container">
                                            <label for="deskripsi_edit">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi_edit" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="stok__edit_container">
                                            <label for="stok_edit">Stok</label>
                                            <input type="number" class="form-control" name="stok" id="stok_edit"
                                                placeholder="Stok">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="gambar__edit_container">
                                            <label for="gambar_edit">Gambar</label>
                                            <input type="file" class="form-control" name="gambar" id="gambar_edit"
                                                onchange="previewImage()">
                                            <canvas id="preview_canvas_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_edit" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage() {
                                            var previewCanvas = document.getElementById('preview_canvas_edit');
                                            var previewImage = document.getElementById('preview_image_edit');
                                            var fileInput = document.getElementById('gambar_edit');
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
                                    <div class="col-6">
                                        <div class="form-group" id="status_edit_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group" id="status_diskon_edit_container">
                                            <label for="status_diskon_edit">Status Diskon</label>
                                            <select class="form-control" name="status_diskon" id="status_diskon_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-group" id="harga_jual_diskon_edit_container">
                                            <label for="harga_jual_diskon_edit">Harga Jual Diskon</label>
                                            <input type="text" class="form-control" name="harga_jual_diskon"
                                                id="harga_jual_diskon_edit" placeholder="Harga Jual Diskon">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="youtube_edit_container">
                                            <label for="youtube_edit">Embed Youtube</label>
                                            <input type="text" class="form-control" name="youtube"
                                                id="youtube_edit" placeholder="Embed Youtube">
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        // Event handler saat input berubah pada input harga_beli dan harga_jual
                                        $('#harga_beli_edit, #harga_jual_edit, #harga_jual_diskon_edit').on('input', function(
                                            e) {
                                            var inputVal = $(this).val().replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
                                            var formattedVal = addThousandSeparator(inputVal);
                                            $(this).val(formattedVal);
                                        });

                                        // Fungsi untuk menambahkan separator ribuan
                                        function addThousandSeparator(num) {
                                            var parts = num.toString().split(".");
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            return parts.join(".");
                                        }
                                    });
                                </script>
                                @if ($isAdmin)
                                    <div class="col-12">
                                        <div class="form-group" id="urutan_edit_container">
                                            <label for="urutan_edit">Urutan</label>
                                            <input type="number" class="form-control" name="urutan" id="urutan_edit"
                                                placeholder="Urutan">
                                        </div>
                                    </div>
                                @endif

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet"
        type="text/css"href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <!-- jQuery -->
    {{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- DataTables Responsive JS -->
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> --}}


    <script src="{{ asset('themplete/back') }}/plugins/summernote/summernote-bs4.min.js"></script>

    {{-- Summernote --}}
    <script>
        $(function() {
            // Summernote
            $('#deskripsi').summernote({
                height: 200
            });


        })
    </script>
    {{-- Summernote --}}



    <script>
        $(function() {
            // Inisialisasi Summernote
            $('#deskripsi_edit').summernote({
                height: 200,
                callbacks: {
                    // Fungsi setelah Summernote selesai dimuat
                    onInit: function() {
                        // Set nilai pada Summernote
                        $('#deskripsi_edit').summernote('code', data.deskripsi_edit);
                    }
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#user_id').select2();
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>



    {{-- perintah slug tambah data --}}
    <script>
        $(document).ready(function() {
            $('#nama_produk').on('input', function() {
                var slug = $(this).val().toLowerCase().replace(/\s+/g, '-');
                $('#slug').val(slug);
            });
        });
    </script>

    {{-- perintah slug edit data --}}
    <script>
        $(document).ready(function() {
            $('#nama_produk_edit').on('input', function() {
                var slug = $(this).val().toLowerCase().replace(/\s+/g, '-');
                $('#slug_edit').val(slug);
            });
        });
    </script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#produkTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('datatables.produk') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        visible: {{ auth()->user()->role === 'administrator' ? 'true' : 'false' }}
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        render: function(data, type, full, meta) {
                            return '<a href="/upload/produk/' + data +
                                '" target="_blank"><img style="max-width:100px; max-height:100px" src="/upload/produk/' +
                                data + '" alt=""></a>';
                        },
                        orderable: false
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 1
                    },
                    {
                        responsivePriority: 3,
                        targets: 2
                    },
                    {
                        responsivePriority: 4,
                        targets: 3
                    },
                    {
                        responsivePriority: 5,
                        targets: 4
                    },
                    {
                        responsivePriority: 6,
                        targets: 5
                    },
                    {
                        responsivePriority: 7,
                        targets: 6
                    }
                ]
            });
        });
    </script>

    {{-- PERINTAH SIMPAN DATA --}}
    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('produk.store') }}',
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
                            // $('#form-tambah').trigger('reset');
                            $('#produkTable').DataTable().ajax.reload();
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
            $('#produkTable').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                console.log('ID: ', id); // Tambahkan log untuk memeriksa ID
                $.ajax({
                    method: 'GET',
                    url: '/produk/' + id + '/edit',
                    success: function(data) {
                        console.log('Data dari server: ',
                            data); // Tambahkan log untuk memeriksa data yang diterima

                        $('#id').val(data.id);
                        $('#user_id_edit').val(data.user_id);
                        $('#nama_produk_edit').val(data.nama_produk);
                        $('#kategori_produk_id_edit').val(data.kategori_produk_id);
                        $('#harga_beli_edit').val(data.harga_beli);
                        $('#harga_jual_edit').val(data.harga_jual);
                        $('#deskripsi_edit').summernote('code', data.deskripsi);
                        $('#stok_edit').val(data.stok);
                        $('#slug_edit').val(data.slug);
                        $('#youtube_edit').val(data.youtube);
                        $('#urutan_edit').val(data.urutan);
                        $('#harga_jual_diskon_edit').val(data.harga_jual_diskon);

                        // Set nilai dan tambahkan log untuk memastikan bahwa nilai benar-benar di-set
                        $('#status_edit').val(data.status);
                        $('#status_diskon_edit').val(data.status_diskon);

                        // Atur properti selected secara eksplisit
                        $('#status_edit option').each(function() {
                            if ($(this).val() == data.status) {
                                $(this).prop('selected', true);
                            }
                        });

                        $('#status_diskon_edit option').each(function() {
                            if ($(this).val() == data.status_diskon) {
                                $(this).prop('selected', true);
                            }
                        });

                        // Tambahkan log untuk memeriksa nilai setelah pengaturan
                        console.log('Status:', data.status);
                        console.log('Status Diskon:', data.status_diskon);
                        console.log('Element status_edit value after setting:', $(
                            '#status_edit').val());
                        console.log('Element status_diskon_edit value after setting:', $(
                            '#status_diskon_edit').val());

                        // Hapus gambar yang ada sebelum menambahkan gambar yang baru
                        $('#gambar_edit_container img').remove();
                        $('#gambar_edit_container a').remove();

                        // Tambahkan logika untuk menampilkan gambar bukti pada formulir edit
                        if (data.gambar) {
                            var gambarImg = '<img src="/upload/produk/' + data.gambar +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var gambarLink = '<a href="/upload/produk/' + data.gambar +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#gambar_edit_container').append(gambarImg + '<br>' + gambarLink);
                        }

                        $('#modal-edit').modal('show');
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
                    url: '/produk/' + id,
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
                            url: '/produk/' + id,
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
