@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


@section('content')


    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button -->
                <div class="back-button">
                    <a href="/">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <!-- Page Title -->
                <div class="page-heading">
                    <h6 class="mb-0">{{ $subtitle }} - {{ $profil->nama_perusahaan }}</h6>
                </div>

                <!-- Settings -->
                <div class="setting-wrapper">
                    <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas"
                        data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="row g-3 justify-content-center">
                @foreach ($kurir as $p)
                    <!-- Single Blog Card -->
                    <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                        <div class="card shadow-sm blog-list-card">
                            <div class="d-flex align-items-center">
                                <div class="card-blog-img position-relative btn-edit"
                                    style="background-image: url('/upload/kurir/{{ $p->gambar }}')"
                                    data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $p->id }}">
                                    <span
                                        class="badge bg-warning text-dark position-absolute card-badge">{{ $p->afiliasi }}</span>
                                </div>
                                <div class="card-blog-content">
                                    <span
                                        class="badge bg-danger rounded-pill mb-2 d-inline-block">{{ $p->no_wa }}</span>
                                    <a class="blog-title d-block mb-3 text-dark btn-edit" href="#"
                                        data-bs-toggle="modal" data-bs-target="#modal-edit"
                                        data-id="{{ $p->id }}">{{ $p->nama_kurir }}</a>
                                    <a class="btn btn-success btn-sm"
                                        href="https://wa.me/{{$p->no_wa }}" target="_blank">
                                        <i class="bi bi-whatsapp me-1"></i> Hubungi Kurir
                                    </a>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="card mt-3">
                        <div class="card-body p-3">
                            <nav aria-label="Page navigation example">
                                {{ $kurir->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-editLabel">Detail Kurir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kurir-details">
                        <!-- Detail kurir akan dimuat di sini secara dinamis -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_kurir_edit" class="form-label">Nama Kurir</label>
                                        <p id="nama_kurir_edit"></p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="umur_edit" class="form-label">Umur</label>
                                        <p id="umur_edit"></p>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="no_wa_edit" class="form-label">No WA</label>
                                        <p id="no_wa_edit"></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_edit" class="form-label">Alamat</label>
                                        <p id="alamat_edit"></p>
                                    </div>
                                    {{-- <div class="col-md-12 mb-3" id="gambar_edit_container">
                                        <!-- Gambar bukti akan dimuat di sini -->
                                    </div> --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi_edit" class="form-label">Deskripsi</label>
                                        <p id="deskripsi_edit"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- PERINTAH EDIT DATA --}}
    <script>
        $(document).ready(function() {
    $('.btn-edit').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            method: 'GET',
            url: '/kurir_page/' + id,
            success: function(data) {
                // Mengisi data pada form modal
                $('#nama_kurir_edit').text(data.nama_kurir);
                $('#tempat_lahir_edit').text(data.tempat_lahir);

                // Format tanggal lahir
                var tanggalLahir = new Date(data.tanggal_lahir);
                var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                var formattedTanggalLahir = tanggalLahir.toLocaleDateString('id-ID', options);
                $('#tanggal_lahir_edit').text(formattedTanggalLahir);

                // Menghitung umur
                var today = new Date();
                var age = today.getFullYear() - tanggalLahir.getFullYear();
                var monthDiff = today.getMonth() - tanggalLahir.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < tanggalLahir.getDate())) {
                    age--;
                }
                $('#umur_edit').text(age);

                $('#alamat_edit').text(data.alamat);
                $('#no_wa_edit').text(data.no_wa);
                $('#afiliasi_edit').text(data.afiliasi);
                $('#deskripsi_edit').text(data.deskripsi);

                // Hapus gambar yang ada sebelum menambahkan gambar yang baru
                $('#gambar_edit_container img').remove();
                $('#gambar_edit_container a').remove();

                // Tambahkan logika untuk menampilkan gambar bukti pada formulir edit
                if (data.gambar) {
                    var gambarImg = '<img src="/upload/kurir/' + data.gambar + '" style="max-width: 200px; max-height: 200px;">';
                    var gambarStatus = '<a href="/upload/kurir/' + data.gambar + '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                    $('#gambar_edit_container').append(gambarImg + '<br>' + gambarStatus);
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
@endpush
