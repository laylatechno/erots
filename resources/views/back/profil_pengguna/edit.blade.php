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



            <form action="{{ route('profil.update_pengguna', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">

                            @if ($data->avatar && file_exists(public_path('upload/user/' . $data->avatar)))
                                <a href="/upload/user/{{ $data->avatar }}">
                                    <img class="usere-user-img img-fluid img-circle" src="/upload/user/{{ $data->avatar }}"
                                        alt="User profile avatar">
                                </a>
                            @else
                                <a href="/upload/avatar.png">
                                    <img class="profile-user-img img-fluid img-circle" src="/upload/avatar.png"
                                        alt="User profile picture">
                                </a>
                            @endif

                        </div>


                        <h3 class="profile-username text-center"><b>{{ $data->name }}</b></h3>

                        <p class="text-muted text-center">Username : {{ $data->user }} </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Facebook</b> <a class="float-right"><input type="text" class="form-control"
                                        id="facebook" name="facebook" value="{{ $data->facebook }}"></a>
                            </li>

                            <li class="list-group-item">
                                <b>Instagram</b> <a class="float-right"><input type="text" class="form-control"
                                        id="instagram" name="instagram" value="{{ $data->instagram }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Tiktok</b> <a class="float-right"><input type="text" class="form-control"
                                        id="tiktok" name="tiktok" value="{{ $data->tiktok }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Shopee</b> <a class="float-right"><input type="text" class="form-control"
                                        id="shopee" name="shopee" value="{{ $data->shopee }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Bukalapak</b> <a class="float-right"><input type="text" class="form-control"
                                        id="bukalapak" name="bukalapak" value="{{ $data->bukalapak }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Tokopedia</b> <a class="float-right"><input type="text" class="form-control"
                                        id="tokopedia" name="tokopedia" value="{{ $data->tokopedia }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Website</b> <a class="float-right"><input type="text" class="form-control"
                                        id="website" name="website" value="{{ $data->website }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Youtube</b> <a class="float-right"><input type="text" class="form-control"
                                        id="youtube" name="youtube" value="{{ $data->youtube }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Embed YTB</b> <a class="float-right"><input type="text" class="form-control"
                                        id="embed_youtube" name="embed_youtube" value="{{ $data->embed_youtube }}"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Link lain</b> <a class="float-right"><input type="text" class="form-control"
                                        id="link" name="link" value="{{ $data->link }}"></a>
                            </li>


                        </ul>


                        <a href="/dashboard" class="btn btn-danger" style="color:white;"><i
                                class="fas fa-step-backward"></i> Kembali</a>
                        {{-- <a href="#" class="btn btn-primary btn-block"><b>Simpan Social Media</b></a> --}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#umum" data-toggle="tab">Umum</a></li>
                        <li class="nav-item"><a class="nav-link" href="#display" data-toggle="tab">Display</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">

                        <div class="active tab-pane" id="umum">



                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama Anda</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan Nama Anda" value="{{ $data->name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Masukkan Email" value="{{ $data->email }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="user" name="user"
                                        placeholder="Masukkan User" value="{{ $data->user }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="password" name="password"
                                        placeholder="Kosongkan password jika tidak rubah password " value="">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="phone_number" class="col-sm-2 col-form-label">No Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="Masukkan No Telp" value="{{ $data->phone_number }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="wa_number" class="col-sm-2 col-form-label">No WA</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="wa_number" name="wa_number"
                                        placeholder="Masukkan No WA" value="{{ $data->wa_number }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="about" class="col-sm-2 col-form-label">Tentang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="about" name="about"
                                        placeholder="Masukkan Tentang" value="{{ $data->about }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="3">{{ $data->address }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="4">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="maps" class="col-sm-2 col-form-label">Maps</label>
                                <div class="col-sm-10">
                                    <textarea name="maps" class="form-control" id="maps" cols="30" rows="3">{{ $data->maps }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    @if ($data->maps)
                                        <a href="{{ $data->maps }}" class="btn btn-primary" target="_blank">
                                            <i class="fas fa-map-marker-alt"></i> Buka Peta di Google Maps
                                        </a>
                                    @else
                                        <a href="https://maps.google.com" class="btn btn-primary" target="_blank">
                                            <i class="fas fa-map-marked-alt"></i> Buka Google Maps
                                        </a>
                                    @endif
                                </div>
                            </div>







                        </div>
                        <!-- /.tab-pane -->



                        <div class="tab-pane" id="display">

                            <!-- The timeline -->
                            <div class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-success">
                                        Gambar Anda
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>


                                    <div class="timeline-item">


                                        <h3 class="timeline-header"><a href="#">Pilih Gambar terbaik</a> untuk
                                            Usaha anda</h3>

                                        <div class="timeline-body">
                                            <a href="/upload/user/{{ $data->picture }}" target="_blank">
                                                <img class="img-bordered-sm" width="200px" height="200px;"
                                                    src="/upload/user/{{ $data->picture }}" alt="user image">
                                            </a>

                                        </div>
                                        <div class="timeline-footer">
                                            <input type="file" name="picture" id="picture">
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
                                        Avatar Website
                                    </span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>


                                    <div class="timeline-item">


                                        <h3 class="timeline-header"><a href="#">Pilih avatar</a> untuk website
                                            Perusahaan anda</h3>

                                        <div class="timeline-body">
                                            <a href="/upload/user/{{ $data->avatar }}" target="_blank">
                                                <img class="img-bordered-sm" width="200px" height="200px;"
                                                    src="/upload/user/{{ $data->avatar }}" alt="user image">
                                            </a>
                                        </div>
                                        <div class="timeline-footer">
                                            <input type="file" name="avatar" id="avatar">
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
                                            <a href="/upload/user/{{ $data->banner }}" target="_blank">
                                                <img class="img-bordered-sm" width="200px" height="100px;"
                                                    src="/upload/user/{{ $data->banner }}" alt="user image">
                                            </a>
                                        </div>
                                        <div class="timeline-footer">
                                            <input type="file" name="banner" id="banner">
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->








                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>


                            </div>

                        </div>
                        <!-- /.tab-pane -->


                    </div>
                    <!-- /.tab-content -->

                    <button type="submit" class="btn btn-success" style="color:white;"><i class="fas fa-save"></i>
                        Update Data</button>
                    </form>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>




@endsection
