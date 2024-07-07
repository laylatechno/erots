<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil->nama_perusahaan }} | @yield('title') @if (request()->route()->getName() === 'toko.toko_detail')
            | {{ $users->name }}
        @endif
    </title>



    <!-- Include all your CSS files here -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('themplete/back/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="/upload/profil/{{ $profil->favicon }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('themplete/back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('themplete/back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('themplete/back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        @media print {
            #unhide {
                display: none;
            }
        }
    </style>

    @stack('css')


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            {{-- <img class="animation__shake" src="" alt="Master" height="60" width="60" id="preloaderLogo"> --}}
            <img class="animation__shake" src="/upload/profil/{{ $profil->logo }}" alt="Master" height="100"
                width="100" id="preloaderLogo">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://wa.me/{{ $profil->no_wa }}" class="nav-link">Kontak Person</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" target="_blank" class="nav-link">Lihat Website</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" style="color: rgb(5, 5, 5);">
                        <span>({{ Auth::user()->role }})</span>
                    </a>

                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" style="color: red;">
                        <i class="far fa-envelope"></i> <b>Kontak Masuk
                        </b>
                    </a>

                </li> --}}

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="/logout" class="nav-link" style="color: red;">
                        <i class="nav-icon fas fa-undo"></i> <b>Logout
                        </b>
                    </a>

                </li>

            </ul>
        </nav>
        <!-- /.navbar -->


        {{-- Sidebar --}}


        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/dashboard" class="brand-link">
                <img src="/upload/profil/{{ $profil->logo }}" alt="" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $profil->nama_perusahaan }}</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/upload/user/{{ Auth::user()->avatar ?: 'avatar.png' }}"
                            class="img-circle elevation-2" alt="User Image"
                            onerror="this.onerror=null;this.src='/upload/avatar.png';">
                    </div>

                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <?php $currentPath = $_SERVER['REQUEST_URI']; ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Auth::user()->role === 'administrator')
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link <?php echo $currentPath == '/dashboard' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-header">Master</li>
                            <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_produk') !== false || strpos($currentPath, '/produk') !== false ? 'menu-open active' : ''; ?> ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Data Produk
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/kategori_produk" class="nav-link <?php echo $currentPath == '/kategori_produk' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Produk</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/produk" class="nav-link <?php echo $currentPath == '/produk' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Produk</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_berita') !== false || strpos($currentPath, '/berita') !== false ? 'menu-open active' : ''; ?> ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-blog"></i>
                                    <p>
                                        Data Berita
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/kategori_berita" class="nav-link <?php echo $currentPath == '/kategori_berita' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Berita</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/berita" class="nav-link <?php echo $currentPath == '/berita' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Berita</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li class="nav-item 
                        <?php echo strpos($currentPath, '/kategori_galeri') !== false || strpos($currentPath, '/galeri') !== false ? 'menu-open active' : ''; ?> ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-film"></i>
                                    <p>
                                        Data Galeri
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/kategori_galeri" class="nav-link <?php echo $currentPath == '/kategori_galeri' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Galeri</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/galeri" class="nav-link <?php echo $currentPath == '/galeri' ? 'active' : ''; ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Galeri</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="/slider" class="nav-link <?php echo $currentPath == '/slider' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-images"></i>

                                    <p>
                                        Slider
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/info" class="nav-link <?php echo $currentPath == '/info' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-info"></i>

                                    <p>
                                        Informasi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/layanan" class="nav-link <?php echo $currentPath == '/layanan' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-list"></i>

                                    <p>
                                        Layanan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/alasan" class="nav-link <?php echo $currentPath == '/alasan' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-feather"></i>

                                    <p>
                                        Alasan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/testimoni" class="nav-link <?php echo $currentPath == '/testimoni' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-paper-plane"></i>

                                    <p>
                                        Testimoni
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/konsumen" class="nav-link <?php echo $currentPath == '/konsumen' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-users"></i>

                                    <p>
                                        Konsumen
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/pembelian" class="nav-link <?php echo $currentPath == '/pembelian' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-shopping-bag"></i>

                                    <p>
                                        Transaksi Pembelian
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/penjualan" class="nav-link <?php echo $currentPath == '/penjualan' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-shopping-cart"></i>

                                    <p>
                                        Transaksi Penjualan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-header">Pengaturan</li>
                            <li class="nav-item">
                                <a href="/profil/1/edit" class="nav-link <?php echo $currentPath == '/profil/1/edit' ? 'active' : ''; ?>">
                                    <i class="nav-icon far fa-plus-square"></i>
                                    <p>
                                        Profil Umum
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link <?php echo $currentPath == '/users' ? 'active' : ''; ?>">
                                    <i class="nav-icon far fa-user"></i>
                                    <p style="margin-right: 6px;">
                                        User
                                    </p>
                                    @if ($nonActiveUserCount > 0)
                                        <span class="badge bg-danger">{{ $nonActiveUserCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/profil_pengguna/{{ Auth::user()->id }}/edit" class="nav-link">
                                    <i class="nav-icon far fa-edit"></i>
                                    <p>
                                        Edit Profil
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backup_database" class="nav-link <?php echo $currentPath == '/backup_database' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Back Up Database
                                    </p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('log_histori.index') }}" class="nav-link <?php echo $currentPath == '/log_histori' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        Log Histori
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->role === 'pengguna')
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link <?php echo $currentPath == '/dashboard' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li
                                class="nav-item {{ strpos($currentPath, '/kategori_produk') !== false || strpos($currentPath, '/produk') !== false ? 'menu-open active' : '' }}">
                                <a href="/produk" class="nav-link {{ $currentPath == '/produk' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Produk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/profil_pengguna/{{ Auth::user()->id }}/edit" class="nav-link">
                                    <i class="nav-icon far fa-edit"></i>
                                    <p>Edit Profil</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">@yield('subtitle')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    @yield('content')


                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <footer class="main-footer" id="unhide">
        All Rights Reserved by Layla Techno &copy; {{ date('Y') }}. Designed and Developed by <a
            href="https://www.ltpresent.com">Layla Techno</a>.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>

    <!-- Include all your JS files here -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('themplete/back/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('themplete/back/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('themplete/back/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('themplete/back/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')



    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [5, 10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // Tambahkan konfigurasi untuk example4 yang sama dengan example1
            $("#example4").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
        });
    </script>








</body>

</html>
