@extends('back.layouts.app')
@section('title','Halaman Profil')
@section('subtitle','Menu Profil')

@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Profil - {{ $profil->nama_sekolah }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ($message = Session::get('message'))
            <div class="alert alert-success" role="alert">
                {{ $message}}
            </div> 
            @endif

            @if ($message = Session::get('messagehapus'))
            <div class="alert alert-danger" role="alert">
                {{ $message}}
            </div> 
            @endif
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Nama Sekolah</th>
              <th>Status</th>
              <th>NPSN</th>
              <th>Kepala Sekolah</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>


                <?php $i = 1; ?>
                @foreach ($profil as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->nama_sekolah}}</td>
                    <td>{{ $p->status}}</td>
                    <td>{{ $p->npsn}}</td>
                    <td>{{ $p->kepala_sekolah_id}}</td>
                    

                    

                    <td><a href="/upload/profil/{{ $p->logo}}" target="_blank"><img style="max-width:50px; max-height:50px" src="/upload/profil/{{ $p->logo}}" alt=""></a></td>
                                  
                     
                     
                
                    <td>
                        <a href="{{ route('profil.edit',$p->id)}}" class="btn btn-sm btn-warning" style="color: black"><i class="fas fa-edit"></i> Lihat & Edit</a>
                    </td>
                </tr>
                <?php $i++; ?>
                @endforeach
            
  
            </tbody>
            <tfoot>
            <tr>
                <th>No</th>
                <th>Nama Sekolah</th>
                <th>Status</th>
                <th>NPSN</th>
                <th>Kepala Sekolah</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
     
       
 
@endsection