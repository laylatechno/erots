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

                <a href="{{ route('log-histori.delete-all') }}" class="btn btn-danger mb-3"
                    onclick="return confirm('Apakah Anda Yakin Akan Menghapus Semua Data, silahkan Back Up terlebih dahulu?')">
                    <i class="fa fa-trash"></i> Hapus Semua Data
                </a>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Member</th>
                            <th>No Transaksi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiHeads as $transaksiHead)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksiHead->user->name }}</td>
                            <td>{{ $transaksiHead->no_transaksi }}</td>
                            <td>{{ $transaksiHead->total }}</td>
                            <td>{{ $transaksiHead->status }}</td>
                            <td>
                                <button class="btn btn-sm btn-info btn-detail" data-id="{{ $transaksiHead->id }}" style="color: white">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </button>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $transaksiHead->id }}" style="color: white">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
            <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
              <h3 class="card-title">{{ $profil->nama_perusahaan }} - {{ $subtitle }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
 

              <!-- Tabel detail transaksi -->
              <h3 class="mt-5">Detail Transaksi</h3>
              <table id="example3" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama Member</th>
                          <th>No Transaksi</th>
                          <th>Nama Produk</th>
                          <th>Qty</th>
                          <th>Harga</th>
                          <th>Total</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($transaksiDetails as $detail)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $detail->transaksiHead->user->name }}</td>
                          <td>{{ $detail->transaksiHead->no_transaksi }}</td>
                          <td>{{ $detail->produk->nama_produk }}</td>
                          <td>{{ $detail->quantity }}</td>
                          <td>{{ $detail->price }}</td>
                          <td>{{ $detail->total }}</td>
                          <td>{{ $detail->transaksiHead->status }}</td>
                      </tr>
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

<!-- Modal untuk detail transaksi -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten detail transaksi akan dimuat di sini -->
                <div id="detailContent"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <!-- Memuat skrip JavaScript Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.btn-detail').on('click', function() {
                var transaksiId = $(this).data('id');

                // Ajax request untuk mendapatkan detail transaksi
                $.ajax({
                    url: '/transaksi/' + transaksiId,
                    method: 'GET',
                    success: function(response) {
                        $('#detailContent').html(response);
                        $('#detailModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/select2/css/custom.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
