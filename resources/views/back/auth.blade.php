<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - {{ $profil->nama_perusahaan }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="/upload/profil/{{ $profil->favicon }}"> --}}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themplete_login') }}/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themplete_login') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themplete_login') }}/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themplete_login') }}/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themplete_login') }}/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themplete_login') }}/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('themplete_login') }}/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="/upload/profil/{{ $profil->logo }}" width="100%" alt="IMG">
                    {{-- <img src="{{ asset('themplete_login') }}/images/img-01.png" alt="IMG"> --}}
                </div>



                <form class="login100-form validate-form" action="{{ route('auth.login') }}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div style="background-color: brown; text-align:center; color:white;">
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </div>
                        <br>
                    @endif

                    <span class="login100-form-title">
                        Halaman Login
                    </span>

                    <div class="wrap-input100" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email"
                            value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100" data-validate="Password is required">
                        <input class="input100" type="password" name="password" id="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="checkbox">
                        <label>
                            <span>
                                <input type="checkbox" onclick="togglePasswordVisibility()"> Lihat Password
                            </span>
                        </label>
                    </div>

                    <script>
                        function togglePasswordVisibility() {
                            var passwordInput = document.getElementById("password");

                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                            } else {
                                passwordInput.type = "password";
                            }
                        }
                    </script>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit" type="submit">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">

                    </div>

                    <div class="text-center p-t-136">

                    </div>
                </form>
                <br><br>
                <a href="https://wa.me/{{ $profil->no_wa }}">
                    <span>Informasi lebih lanjut : {{ $profil->no_wa }}</span>
                </a>
                <a href="/">
                    <span class="badge badge-danger" style="font-size: 13px;"><i class="fa fa-dashboard" aria-hidden="true"></i> Kembali Ke Halaman Depan</span>
                </a>
              



            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="{{ asset('themplete_login') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('themplete_login') }}/vendor/bootstrap/js/popper.js"></script>
    <script src="{{ asset('themplete_login') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('themplete_login') }}/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('themplete_login') }}/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('themplete_login') }}/js/main.js"></script>

</body>

</html>
