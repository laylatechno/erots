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

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalBerita }} </h3>

                                    <p>Berita</p>
                                </div>
                                <div class="icon">
                                    <i class="ion-ios-paper"></i>   
                                </div>
                                <a href="/berita" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalProduk }} </h3>

                                    <p>Produk</p>
                                </div>
                                <div class="icon">
                                    <i class="ion-android-apps"></i>
                                </div>
                                <a href="/produk" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $totalUser }}</h3>

                                    <p>User</p>
                                </div>
                                <div class="icon">

                                    <i class="ion-android-contacts"></i>
                                </div>
                                <a href="/user" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <!-- /.row -->




                    <!-- Section for the Gender-based Chart -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    Grafik Data Produk Berdasarkan Pengguna
                                </div>
                                <div class="card-body">
                                    <canvas id="chartProduk"></canvas> <!-- Periksa apakah ID cocok -->
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    Kunjungan Website
                                </div>
                                <div class="card-body">
                                    <canvas id="visitors"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>





                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var visitData = @json($visits); // Data dari controller

            var dates = visitData.map(v => v.date); // Ambil tanggal
            var counts = visitData.map(v => v.count); // Ambil jumlah kunjungan

            var ctx = document.getElementById("visitors").getContext("2d");

            new Chart(ctx, {
                type: 'line', // Grafik garis
                data: {
                    labels: dates, // Label sumbu-x
                    datasets: [{
                        label: 'Kunjungan',
                        data: counts, // Data sumbu-y
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                        borderWidth: 1, // Lebar garis
                    }],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true, // Mulai sumbu-y dari nol
                        },
                    },
                },
            });
        });
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartProduk").getContext("2d");

        // Data chart dari controller
        var chartData = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: chartData.datasets[0].label,
                    backgroundColor: chartData.datasets[0].backgroundColor,
                    data: chartData.datasets[0].data
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // Letakkan legenda di atas grafik
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                // Menampilkan label, nilai, dan persentase di tooltip
                                var dataset = chartData.datasets[0];
                                var total = dataset.data.reduce(function(previousValue, currentValue) {
                                    return previousValue + currentValue;
                                });
                                var currentValue = dataset.data[tooltipItem.index];
                                var percentage = Math.floor(((currentValue / total) * 100) + 0.5);

                                return `${dataset.labels[tooltipItem.index]}: ${currentValue} ( ${percentage}% )`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>



@endsection
