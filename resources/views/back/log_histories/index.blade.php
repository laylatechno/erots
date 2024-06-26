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
          
          <!-- Add this link/button in your view file -->
            

            {{-- <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-spp"><i class="fas fa-plus-circle"></i> Tambah Data</a>   --}}
            <a href="{{ route('log-histori.delete-all') }}" class="btn btn-danger mb-3" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Semua Data, silahkan Back Up terlebih dahulu?')"><i class="fa fa-trash"></i> Hapus Semua Data</a>       
      
           
           
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Tabel</th>
              <th>ID Entitas</th>
              <th>Aksi</th>
              <th>Waktu</th>
              <th>Pengguna</th>
              <th>Data Lama</th>
              <th>Data Baru</th>
              
            </tr>
            </thead>
            <tbody>

              @foreach ($log_histori as $p)
                      <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $p->Tabel_Asal }}</td>
                  <td>{{ $p->ID_Entitas }}</td>
                  <td>{{ $p->Aksi }}</td>
                  <td>{{ $p->Waktu }}</td>
                  <td>{{ $p->Waktu }}</td>
                  {{-- <td>{{ $p->user->name }}</td> --}}
                  <td>{{ $p->Data_Lama }}</td>
                  <td>{{ $p->Data_Baru }}</td>
                 
                 
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

 
 
  
  @endsection


 
@push('scripts')
 
<!-- Memuat skrip JavaScript Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 
<!-- Script JavaScript untuk Tombol Hapus Semua Data -->
 

 
 

 
@endpush


@push('css')
<link rel="stylesheet" href="{{ asset('themplete/back/plugins/select2/css/custom.css') }}">
<style>
  .select2-container{
    width: 100% !important;
    
  }
</style>
@endpush





 