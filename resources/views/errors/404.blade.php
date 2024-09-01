<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Lapaktasik.com">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <meta name="theme-color" content="#0134d4">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <!-- Title -->
  <title>Lapaktasik.com - Page Not Found</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('upload/profil/' . $profil->favicon) }}">
  <link rel="apple-touch-icon" href="{{ asset('themplete/front') }}/img/icons/icon-96x96.png">
  <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
  <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">

  <!-- Style CSS -->
  <link rel="stylesheet" href="{{ asset('themplete/front') }}/style.css">

  <!-- Web App Manifest -->
  <link rel="manifest" href="{{ asset('themplete/front') }}/manifest.json">
</head>

<body>
  <!-- Preloader -->
  <div id="preloader">
    <div class="spinner-grow text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- Internet Connection Status -->
  <div class="internet-connection-status" id="internetStatus"></div>

  <!-- Static Backdrop Modal -->
  <div class="cs-newsletter-form modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          <h6 class="mb-3">Subscribe our newsletter.</h6>
          <form action="#">
            <input class="form-control mb-3" type="email" placeholder="Enter your email">
            <button class="btn btn-primary w-100" type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Page Content Wrapper -->
  <div class="coming-soon-wrapper bg-white text-center bg-overlay" style="background-image: url('{{ asset('themplete/front') }}/img/bg-img/26.jpg')">
    <div class="container">
        <a href="/">
            <img src="{{ asset('upload/profil/' . $profil->logo) }}" alt="" style="width: 50%;">
         </a>
      <h2 class="text-white display-3">404 - Oops! Page Not Found</h2>
      <p class="text-white">The page you're looking for doesn't exist or has been moved</p>

      <div class="countdown2 justify-content-center" id="countdown2" data-date="11-6-2022" data-time="23:24">
        <div class="day">
          <span class="num"></span>
          <span class="word"></span>
        </div>
        <div class="hour">
          <span class="num"></span>
          <span class="word"></span>
        </div>
        <div class="min">
          <span class="num"></span>
          <span class="word"></span>
        </div>
        <div class="sec">
          <span class="num"></span>
          <span class="word"></span>
        </div>
      </div>

      <div class="notify-email mt-5">
        <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
      </div>
    </div>
  </div>

  <!-- All JavaScript Files -->
  <script src="{{ asset('themplete/front') }}/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/slideToggle.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/internet-status.js"></script>
  <script src="{{ asset('themplete/front') }}/js/tiny-slider.js"></script>
  <script src="{{ asset('themplete/front') }}/js/venobox.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/countdown.js"></script>
  <script src="{{ asset('themplete/front') }}/js/rangeslider.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/vanilla-dataTables.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/index.js"></script>
  <script src="{{ asset('themplete/front') }}/js/imagesloaded.pkgd.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/isotope.pkgd.min.js"></script>
  <script src="{{ asset('themplete/front') }}/js/dark-rtl.js"></script>
  <script src="{{ asset('themplete/front') }}/js/active.js"></script>
  <script src="{{ asset('themplete/front') }}/js/pwa.js"></script>
</body>

</html>
