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

                    <a href="{{ route('visitor.delete-all') }}" class="btn btn-danger mb-3" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Semua Data, silahkan Back Up terlebih dahulu?')"><i class="fa fa-trash"></i> Hapus Semua Data</a>       
      
                  
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Platform</th>
                                <th>Device</th>
                                <th>Browser</th>
                          
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            @foreach ($visitor as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->visit_time }}</td>
                                    <td>{{ $p->ip_address }}</td>
                                    <td>{{ $p->user_agent }}</td>
                                    <td>{{ $p->platform }}</td>
                                    <td>{{ $p->device }}</td>
                                    <td>{{ $p->browser }}</td>
                                    
                                  
                                </tr>
                                <?php $i++; ?>
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
   
@endpush
