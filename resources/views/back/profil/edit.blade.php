@extends('back.layouts.app')
@section('title', 'Halaman Profil')
@section('subtitle', 'Menu Profil')

@section('content')
    @if ($message = Session::get('message'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('messagehapus'))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-3">



            <form action="{{ route('profil.update_media_sosial', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                           
                          @if($data->logo && file_exists(public_path('upload/profil/' . $data->logo)))
                          <a href="/upload/profil/{{ $data->logo }}">
                              <img class="profile-user-img img-fluid img-circle"
                                   src="/upload/profil/{{ $data->logo }}"
                                   alt="User profile picture">
                          </a>
                      @else
                          <a href="https://media.istockphoto.com/id/1300845620/id/vektor/ikon-pengguna-datar-terisolasi-pada-latar-belakang-putih-simbol-pengguna-ilustrasi-vektor.jpg?s=612x612&w=0&k=20&c=QN0LOsRwA1dHZz9lsKavYdSqUUnis3__FQLtZTQ--Ro=">
                              <img class="profile-user-img img-fluid img-circle"
                                   src="https://media.istockphoto.com/id/1300845620/id/vektor/ikon-pengguna-datar-terisolasi-pada-latar-belakang-putih-simbol-pengguna-ilustrasi-vektor.jpg?s=612x612&w=0&k=20&c=QN0LOsRwA1dHZz9lsKavYdSqUUnis3__FQLtZTQ--Ro="
                                   alt="User profile picture">
                          </a>
                      @endif
                      
                        </div>


                        <h3 class="profile-username text-center"><b>{{ $data->nama_perusahaan }}</b></h3>

                        <p class="text-muted text-center">ID Usaha : {{ $data->no_id }} </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right"><input type="text" class="form-control"
                                        id="email" name="email" value="{{ $data->email }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>WhatsApp</b> <a class="float-right"><input type="text" class="form-control"
                                        id="no_wa" name="no_wa" value="{{ $data->no_wa }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Instagram</b> <a class="float-right"><input type="text" class="form-control"
                                        id="instagram" name="instagram" value="{{ $data->instagram }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Facebook</b> <a class="float-right"><input type="text" class="form-control"
                                        id="facebook" name="facebook" value="{{ $data->facebook }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Youtube</b> <a class="float-right"><input type="text" class="form-control"
                                        id="youtube" name="youtube" value="{{ $data->youtube }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Website</b> <a class="float-right"><input type="text" class="form-control"
                                        id="website" name="website" value="{{ $data->website }}"></a>
                            </li>
                        </ul>

                        <button type="submit" class="btn btn-success" style="color:white;"><i class="fas fa-save"></i>
                            Update Media Sosial</button>
                        <a href="/dashboard" class="btn btn-danger" style="color:white;"><i
                                class="fas fa-step-backward"></i> Kembali</a>
                        {{-- <a href="#" class="btn btn-primary btn-block"><b>Simpan Social Media</b></a> --}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>


        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#umum" data-toggle="tab">Umum</a></li>
                        <li class="nav-item"><a class="nav-link" href="#display" data-toggle="tab">Display</a></li>
                        <li class="nav-item"><a class="nav-link" href="#syarat_ketentuan" data-toggle="tab">Syarat Ketentuan & Map</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">

                        <div class="active tab-pane" id="umum">
                            <form action="{{ route('profil.update_umum', $data->id) }}" method="post">
                                @csrf
                                @method('put')


                                <div class="form-group row">
                                    <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama_perusahaan"
                                            name="nama_perusahaan" placeholder="Masukkan Nama Perusahaan"
                                            value="{{ $data->nama_perusahaan }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_id" class="col-sm-2 col-form-label">ID Usaha</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="no_id" name="no_id"
                                            placeholder="Masukkan ID Usaha" value="{{ $data->no_id }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_telp" class="col-sm-2 col-form-label">No Telp</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            placeholder="Masukkan No Telp" value="{{ $data->no_telp }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="6">{{ $data->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea name="deskripsi" class="form-control" id="deskripsi" cols="30" rows="6">{{ $data->deskripsi }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success" style="color:white;"><i
                                                class="fas fa-save"></i> Update Data Umum</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->



                        <div class="tab-pane" id="display">
                            <form action="{{ route('profil.update_display', $data->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-success">
                                            Logo Perusahaan
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>


                                        <div class="timeline-item">


                                            <h3 class="timeline-header"><a href="#">Pilih Logo terbaik</a> untuk
                                                Perusahaan anda</h3>

                                            <div class="timeline-body">
                                                <a href="/upload/profil/{{ $data->logo }}" target="_blank">
                                                    <img class="img-bordered-sm" width="200px" height="200px;"
                                                        src="/upload/profil/{{ $data->logo }}" alt="user image">
                                                </a>

                                            </div>
                                            <div class="timeline-footer">
                                                <input type="file" name="logo" id="logo">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>



                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>


                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-primary">
                                            Favicon Website
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>


                                        <div class="timeline-item">


                                            <h3 class="timeline-header"><a href="#">Pilih favicon</a> untuk website
                                                Perusahaan</h3>

                                            <div class="timeline-body">
                                                <a href="/upload/profil/{{ $data->favicon }}" target="_blank">
                                                    <img class="img-bordered-sm" width="200px" height="200px;"
                                                        src="/upload/profil/{{ $data->favicon }}" alt="user image">
                                                </a>
                                            </div>
                                            <div class="timeline-footer">
                                                <input type="file" name="favicon" id="favicon">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->



                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-warning">
                                            Banner Website
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>


                                        <div class="timeline-item">


                                            <h3 class="timeline-header"><a href="#">Pilih Banner utama</a> untuk
                                                website Perusahaan</h3>

                                            <div class="timeline-body">
                                                <a href="/upload/profil/{{ $data->gambar }}" target="_blank">
                                                    <img class="img-bordered-sm" width="200px" height="100px;"
                                                        src="/upload/profil/{{ $data->gambar }}" alt="user image">
                                                </a>
                                            </div>
                                            <div class="timeline-footer">
                                                <input type="file" name="gambar" id="gambar">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->








                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-success" style="color:white;"><i
                                        class="fas fa-save"></i> Update Display</button>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="syarat_ketentuan">
                            <form action="{{ route('profil.update_syarat', $data->id) }}" method="post">
                                @csrf
                                @method('put')


                               
                                
                                <div class="form-group row">
                                    <label for="map" class="col-sm-2 col-form-label">Map</label>
                                    <div class="col-sm-10">
                                        <textarea name="map" class="form-control" id="map" cols="30" rows="6">{{ $data->map }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="syarat" class="col-sm-2 col-form-label">Syarat</label>
                                    <div class="col-sm-10">
                                        <textarea name="syarat" class="form-control" id="syarat" cols="30" rows="6">{{ $data->syarat }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ketentuan" class="col-sm-2 col-form-label">Ketentuan</label>
                                    <div class="col-sm-10">
                                        <textarea name="ketentuan" class="form-control" id="ketentuan" cols="30" rows="6">{{ $data->ketentuan }}</textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success" style="color:white;"><i
                                                class="fas fa-save"></i> Update Data Syarat Ketentuan & Map</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->


                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>




@endsection

 