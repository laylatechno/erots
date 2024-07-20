<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profil->nama_perusahaan }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <title>{{ $title }} - {{ $profil->nama_perusahaan }}</title>

    <link rel="icon" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="152x152" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="167x167" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="180x180" href="upload/profil/{{ $profil->logo }}">

    <link rel="stylesheet" href="{{ asset('themplete/front') }}/style.css">
    <link rel="manifest" href="{{ asset('themplete/front') }}/manifest.json">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">





</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Welcome Toast -->
    <div id="toast-notification" class="toast toast-autohide custom-toast-1 toast-success home-page-toast d-none"
        role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
        <div class="toast-body">
            <i class="bi bi-bookmark-check text-white h1 mb-0"></i>
            <div class="toast-text ms-3 me-2">
                <p class="mb-1 text-white">Selamat datang di {{ $profil->nama_perusahaan }}</p>
                <small class="d-block">Temukan Produk Terbaik <strong>&amp; Berkualitas</strong> dengan harga yang
                    terjangkau.</small>
            </div>
        </div>
        <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>


    <div class="login-back-button">
        <a href="/">
            <i class="bi bi-arrow-left-short"></i>
        </a>
    </div>

    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4">
                <img class="login-intro-img" src="{{ asset('themplete/front') }}/img/registrasi_member.png"
                    alt="">
            </div>

            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Daftar untuk Member {{ $profil->nama_perusahaan }}</h6>

                <form id="form-tambah" action="" method="POST">
                    @csrf
                    <div class="form-group text-start mb-3">
                        <input class="form-control" type="text" placeholder="Alamat Email" id="email"
                            name="email" required>
                    </div>

                    <div class="form-group text-start mb-3">
                        <input class="form-control" type="text" placeholder="Username" id="user" name="user"
                            required>
                    </div>
                    <div class="form-group text-start mb-3">
                        <input class="form-control" type="number" placeholder="No WhatsApp" id="wa_number"
                            name="wa_number" required>
                    </div>

                    <div class="form-group text-start mb-3 position-relative">
                        <input class="form-control" id="psw-input" type="password" placeholder="Password Baru"
                            id="password" name="password" required>
                        <div class="position-absolute" id="password-visibility">
                            <i class="bi bi-eye"></i>
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>

                    <div class="mb-3" id="pswmeter"></div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" id="checkedCheckbox" type="checkbox" value="">
                        <label class="form-check-label text-muted fw-normal" for="checkedCheckbox">Setuju dengan
                            ketentuan & kebijakan.</label>
                    </div>

                    <button class="btn btn-danger w-100" type="submit" id="btn-save-tambah" disabled>Checklist untuk
                        Daftar</button>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#checkedCheckbox').change(function() {
                                if ($(this).is(':checked')) {
                                    $('#btn-save-tambah').prop('disabled', false);
                                    $('#btn-save-tambah').removeClass('btn-danger').addClass('btn-primary');
                                    $('#btn-save-tambah').html('Daftar');
                                } else {
                                    $('#btn-save-tambah').prop('disabled', true);
                                    $('#btn-save-tambah').removeClass('btn-primary').addClass('btn-danger');
                                    $('#btn-save-tambah').html('Checklist untuk Daftar');
                                }
                            });
                        });
                    </script>



                </form>
            </div>

            <div class="login-meta-data text-center">
                <p class="mt-3 mb-0">Sudah punya akun? <a class="stretched-link" href="/auth">Login</a></p>
            </div>
            <hr>
            <div class="login-meta-data text-center">
                <p class="mt-3 mb-0">
                    <a style="color:white;" href="auth/redirect">
                        <i class="fab fa-google"></i>&nbsp;&nbsp;Login dengan Google
                    </a>
                </p>
            </div>
            


        </div>
    </div>

    <script src="{{ asset('themplete/front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/internet-status.js"></script>
    <script src="{{ asset('themplete/front') }}/js/dark-rtl.js"></script>
    <script src="{{ asset('themplete/front') }}/js/pswmeter.js"></script>
    <script src="{{ asset('themplete/front') }}/js/active.js"></script>
    <script src="{{ asset('themplete/front') }}/js/pwa.js"></script>
    <script src="{{ asset('themplete/back') }}/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('themplete/back') }}/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('daftar_member.register') }}', // correct route
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(xhr) {
                        $('form').find('.error-message').remove();
                        tombolSimpan.prop('disabled', true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr(
                            'content'));
                    },
                    success: function(response) {
                        // Check response structure and content
                        console.log(response);

                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location
                                .reload(); // Reload page after successful registration
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
</body>

</html>
