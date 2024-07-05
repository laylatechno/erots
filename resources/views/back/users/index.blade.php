@extends('back.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')
    <style>
        .color-sample {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            border-radius: 50%;
            vertical-align: middle;
        }

        .primary {
            background-color: #007bff;
        }

        .secondary {
            background-color: #6c757d;
        }

        .success {
            background-color: #28a745;
        }

        .warning {
            background-color: #ffc107;
        }

        .danger {
            background-color: #dc3545;
        }

        .info {
            background-color: #17a2b8;
        }

        .light {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        /* Light color with border */
        .dark {
            background-color: #343a40;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Catering Pro - {{ $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i
                            class="fas fa-plus-circle"></i> Tambah Data</a>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="5%">Avatar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            @foreach ($users as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->user }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->role }}</td>
                                    <td>
                                        @if ($p->status == 'Aktif')
                                            <span class="badge bg-success">{{ $p->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $p->status }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($p->avatar && file_exists(public_path("/upload/user/$p->avatar")))
                                            <a href="/upload/user/{{ $p->avatar }}" target="_blank">
                                                <img style="max-width:100px; max-height:100px" src="/upload/user/{{ $p->avatar }}" alt="">
                                            </a>
                                        @else
                                            <img style="max-width:100px; max-height:100px" src="/upload/avatar.png" alt="Default Avatar">
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                            data-target="#modal-edit" data-id="{{ $p->id }}" style="color: black">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}"
                                            style="color: white">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>

                                    </td>
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



    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form {{ $subtitle }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Main content -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form id="form-tambah" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-3">
                                        <div class="form-group" id="name_container">
                                            <label for="name">Nama User</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Nama User">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="email_container">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control " name="email" id="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="role_container">
                                            <label for="role">Role</label>
                                            <select class="form-control" name="role" id="role">
                                                <option value="">--Pilih Role--</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="admin">Admin</option>
                                                <option value="kasir">Kasir</option>
                                                <option value="pengguna">Pengguna</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="phone_number_container">
                                            <label for="phone_number">No Telp</label>
                                            <input type="number" class="form-control " name="phone_number"
                                                id="phone_number" placeholder="No Telp">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="wa_number_container">
                                            <label for="wa_number">No WA</label>
                                            <input type="number" class="form-control " name="wa_number" id="wa_number"
                                                placeholder="No WA">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="about_container">
                                            <label for="about">Tentang</label>
                                            <input type="text" class="form-control " name="about" id="about"
                                                placeholder="Tentang">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="website_container">
                                            <label for="website">Website</label>
                                            <input type="text" class="form-control " name="website" id="website"
                                                placeholder="Website">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="link_container">
                                            <label for="link">Link</label>
                                            <input type="text" class="form-control " name="link" id="link"
                                                placeholder="Link">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="address_container">
                                            <label for="address">Alamat</label>
                                            <textarea class="form-control" name="address" id="address" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="description_container">
                                            <label for="description">Deskripsi</label>
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="shopee_container">
                                            <label for="shopee">Shopee</label>
                                            <input type="text" class="form-control " name="shopee" id="shopee"
                                                placeholder="Shopee">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="tokopedia_container">
                                            <label for="tokopedia">Tokopedia</label>
                                            <input type="text" class="form-control " name="tokopedia" id="tokopedia"
                                                placeholder="Tokopedia">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="bukalapak_container">
                                            <label for="bukalapak">Bukalapak</label>
                                            <input type="text" class="form-control " name="bukalapak" id="bukalapak"
                                                placeholder="Bukalapak">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="tiktok_container">
                                            <label for="tiktok">Tiktok</label>
                                            <input type="text" class="form-control " name="tiktok" id="tiktok"
                                                placeholder="Tiktok">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="instagram_container">
                                            <label for="instagram">Instagram</label>
                                            <input type="text" class="form-control " name="instagram" id="instagram"
                                                placeholder="Instagram">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="facebook_container">
                                            <label for="facebook">Facebook</label>
                                            <input type="text" class="form-control " name="facebook" id="facebook"
                                                placeholder="Facebook">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group" id="color_container">
                                            <label for="color">Warna</label>
                                            <select class="form-control" name="color" id="color">
                                                <option value="">--Pilih Warna--</option>
                                                <option value="primary" class="primary">Primary</option>
                                                <option value="secondary" class="secondary">Secondary</option>
                                                <option value="success" class="success">Success</option>
                                                <option value="warning" class="warning">Warning</option>
                                                <option value="danger" class="danger">Danger</option>
                                                <option value="info" class="info">Info</option>
                                                <option value="light" class="light">Light</option>
                                                <option value="dark" class="dark">Dark</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group" id="youtube_container">
                                            <label for="youtube">Youtube</label>
                                            <input type="text" class="form-control" name="youtube" id="youtube"
                                                placeholder="Youtube">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group" id="status_container">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="password_container">
                                            <label for="password">Masukkan Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="confirmation_password_container">
                                            <label for="confirmation_password">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirmation_password"
                                                placeholder="Masukkan Konfirmasi Password">
                                            <span id="password_match_message" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('confirmation_password').addEventListener('keyup', function() {
                                            var password = document.getElementById('password').value;
                                            var confirmationPassword = this.value;
                                            var passwordMatchMessage = document.getElementById('password_match_message');

                                            if (password !== confirmationPassword) {
                                                passwordMatchMessage.textContent = 'Password belum sama.';
                                                passwordMatchMessage.style.color = 'red';
                                            } else {
                                                passwordMatchMessage.textContent = 'Password sudah sama.';
                                                passwordMatchMessage.style.color = 'green'; // Mengubah warna teks menjadi hijau
                                            }
                                        });
                                    </script>



                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="picture_container">
                                            <label for="picture">Gambar</label>
                                            <input type="file" class="form-control" name="picture" id="picture"
                                                onchange="previewImage('picture')">
                                            <canvas id="preview_canvas_picture"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_picture" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <!-- Input gambar untuk avatar -->
                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="avatar_container">
                                            <label for="avatar">Avatar</label>
                                            <input type="file" class="form-control" name="avatar" id="avatar"
                                                onchange="previewImage('avatar')">
                                            <canvas id="preview_canvas_avatar"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_avatar" src="#" alt="Preview Avatar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <!-- Input gambar untuk banner -->
                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="banner_container">
                                            <label for="banner">Banner</label>
                                            <input type="file" class="form-control" name="banner" id="banner"
                                                onchange="previewImage('banner')">
                                            <canvas id="preview_canvas_banner"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_banner" src="#" alt="Preview Banner"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage(type) {
                                            var previewCanvas = document.getElementById('preview_canvas_' + type);
                                            var previewImage = document.getElementById('preview_image_' + type);
                                            var fileInput = document.getElementById(type);
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas.getContext('2d');
                                                    var maxWidth = 200; // Max width untuk pratinja gambar

                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    previewCanvas.width = maxWidth;
                                                    previewCanvas.height = newHeight;

                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Menampilkan pratinja gambar setelah diperkecil
                                                    previewCanvas.style.display = 'block';
                                                    previewImage.style.display = 'none';
                                                };
                                            };

                                            if (file) {
                                                reader.readAsDataURL(file); // Membaca file yang dipilih sebagai URL data
                                            } else {
                                                previewImage.src = '';
                                                previewCanvas.style.display = 'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                            }
                                        }
                                    </script>





                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-tambah"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    {{-- Modal Edit Data --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form {{ $subtitle }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Main content -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->

                        <form id="form-edit" action="" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <!-- Input hidden untuk menyimpan ID -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group" id="name_edit_container">
                                            <label for="name_edit">Nama User</label>
                                            <input type="text" class="form-control" name="name" id="name_edit"
                                                placeholder="Nama User">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="email_edit_container">
                                            <label for="email_edit">Email</label>
                                            <input type="email" class="form-control" name="email" id="email_edit"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="role_edit_container">
                                            <label for="role_edit">Role</label>
                                            <select class="form-control" name="role" id="role_edit">
                                                <option value="">--Pilih Role--</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="admin">Admin</option>
                                                <option value="kasir">Kasir</option>
                                                <option value="pengguna">Pengguna</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="phone_number_edit_container">
                                            <label for="phone_number_edit">No Telp</label>
                                            <input type="number" class="form-control" name="phone_number"
                                                id="phone_number_edit" placeholder="No Telp">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="wa_number_edit_container">
                                            <label for="wa_number_edit">No WA</label>
                                            <input type="number" class="form-control" name="wa_number"
                                                id="wa_number_edit" placeholder="No WA">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="about_edit_container">
                                            <label for="about_edit">Tentang</label>
                                            <input type="text" class="form-control" name="about" id="about_edit"
                                                placeholder="Tentang">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="website_edit_container">
                                            <label for="website_edit">Website</label>
                                            <input type="text" class="form-control" name="website" id="website_edit"
                                                placeholder="Website">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="link_edit_container">
                                            <label for="link_edit">Link</label>
                                            <input type="text" class="form-control" name="link" id="link_edit"
                                                placeholder="Link">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="address_edit_container">
                                            <label for="address_edit">Alamat</label>
                                            <textarea class="form-control" name="address" id="address_edit" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="description_edit_container">
                                            <label for="description_edit">Deskripsi</label>
                                            <textarea class="form-control" name="description" id="description_edit" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="shopee_edit_container">
                                            <label for="shopee_edit">Shopee</label>
                                            <input type="text" class="form-control" name="shopee" id="shopee_edit"
                                                placeholder="Shopee">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="tokopedia_edit_container">
                                            <label for="tokopedia_edit">Tokopedia</label>
                                            <input type="text" class="form-control" name="tokopedia"
                                                id="tokopedia_edit" placeholder="Tokopedia">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="bukalapak_edit_container">
                                            <label for="bukalapak_edit">Bukalapak</label>
                                            <input type="text" class="form-control" name="bukalapak"
                                                id="bukalapak_edit" placeholder="Bukalapak">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="tiktok_edit_container">
                                            <label for="tiktok_edit">Tiktok</label>
                                            <input type="text" class="form-control" name="tiktok" id="tiktok_edit"
                                                placeholder="Tiktok">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="instagram_edit_container">
                                            <label for="instagram_edit">Instagram</label>
                                            <input type="text" class="form-control" name="instagram"
                                                id="instagram_edit" placeholder="Instagram">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="facebook_edit_container">
                                            <label for="facebook_edit">Facebook</label>
                                            <input type="text" class="form-control" name="facebook"
                                                id="facebook_edit" placeholder="Facebook">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group" id="color_edit_container">
                                            <label for="color_edit">Warna</label>
                                            <select class="form-control" name="color" id="color_edit">
                                                <option value="">--Pilih Warna--</option>
                                                <option value="primary" class="primary">Primary</option>
                                                <option value="secondary" class="secondary">Secondary</option>
                                                <option value="success" class="success">Success</option>
                                                <option value="warning" class="warning">Warning</option>
                                                <option value="danger" class="danger">Danger</option>
                                                <option value="info" class="info">Info</option>
                                                <option value="light" class="light">Light</option>
                                                <option value="dark" class="dark">Dark</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group" id="youtube_edit_container">
                                            <label for="youtube_edit">Youtube</label>
                                            <input type="text" class="form-control" name="youtube" id="youtube_edit"
                                                placeholder="Youtube">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" id="status_edit_container">
                                            <label for="status_edit">Status</label>
                                            <select class="form-control" name="status" id="status_edit">
                                                <option value="">--Pilih Status--</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non Aktif">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="password_edit_container">
                                            <label for="password_edit">Masukkan Password</label>
                                            <input type="password" class="form-control" name="password"
                                                id="password_edit" placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" id="confirmation_password_edit_container">
                                            <label for="confirmation_password_edit">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirmation_password_edit"
                                                placeholder="Masukkan Konfirmasi Password">
                                            <span id="password_match_message_edit" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('confirmation_password_edit').addEventListener('keyup', function() {
                                            var password = document.getElementById('password_edit').value;
                                            var confirmationPassword = this.value;
                                            var passwordMatchMessage = document.getElementById('password_match_message_edit');

                                            if (password !== confirmationPassword) {
                                                passwordMatchMessage.textContent = 'Password belum sama.';
                                                passwordMatchMessage.style.color = 'red';
                                            } else {
                                                passwordMatchMessage.textContent = 'Password sudah sama.';
                                                passwordMatchMessage.style.color = 'green';
                                            }
                                        });
                                    </script>
                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="picture_edit_container">
                                            <label for="picture_edit">Gambar</label>
                                            <input type="file" class="form-control" name="picture" id="picture_edit"
                                                onchange="previewImage('picture_edit')">
                                            <canvas id="preview_canvas_picture_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_picture_edit" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="avatar_edit_container">
                                            <label for="avatar_edit">Avatar</label>
                                            <input type="file" class="form-control" name="avatar" id="avatar_edit"
                                                onchange="previewImage('avatar_edit')">
                                            <canvas id="preview_canvas_avatar_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_avatar_edit" src="#" alt="Preview Avatar"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <div class="form-group" id="banner_edit_container">
                                            <label for="banner_edit">Banner</label>
                                            <input type="file" class="form-control" name="banner" id="banner_edit"
                                                onchange="previewImage('banner_edit')">
                                            <canvas id="preview_canvas_banner_edit"
                                                style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image_banner_edit" src="#" alt="Preview Banner"
                                                style="display: none; max-width: 100%; margin-top: 10px;">
                                        </div>
                                    </div>
                                    <script>
                                        function previewImage(type) {
                                            var previewCanvas = document.getElementById('preview_canvas_' + type);
                                            var previewImage = document.getElementById('preview_image_' + type);
                                            var fileInput = document.getElementById(type);
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas.getContext('2d');
                                                    var maxWidth = 200; // Max width untuk pratinja gambar

                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    previewCanvas.width = maxWidth;
                                                    previewCanvas.height = newHeight;

                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Menampilkan pratinja gambar setelah diperkecil
                                                    previewCanvas.style.display = 'block';
                                                    previewImage.style.display = 'none';
                                                };
                                            };

                                            if (file) {
                                                reader.readAsDataURL(file); // Membaca file yang dipilih sebagai URL data
                                            } else {
                                                previewImage.src = '';
                                                previewCanvas.style.display = 'none'; // Menyembunyikan pratinja gambar jika tidak ada file yang dipilih
                                            }
                                        }
                                    </script>
                                </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-save-edit"><i
                                            class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
                                            aria-hidden="true">&times;</span> Close</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection


@push('css')
    <link rel="stylesheet" href="{{ asset('themplete/back/plugins/select2/css/custom.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var colorClass = state.element.className;
                var $state = $(
                    '<span><div class="color-sample ' + colorClass + '"></div>' + state.text + '</span>'
                );
                return $state;
            }

            $('#color').select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var colorClass = state.element.className;
                var $state = $(
                    '<span><div class="color-sample ' + colorClass + '"></div>' + state.text + '</span>'
                );
                return $state;
            }

            $('#color_edit').select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#form-tambah').submit(function(event) {
                event.preventDefault();
                const tombolSimpan = $('#btn-save-tambah')

                // Buat objek FormData
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('users.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, // Menghindari jQuery memproses data
                    contentType: false, // Menghindari jQuery mengatur Content-Type
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        tombolSimpan.prop('disabled', true)
                    },
                    success: function(response) {
                        $('#modal-tambah').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil disimpan',
                            icon: 'success',
                            html: '<br>Data berhasil disimpan', // Tambahkan subjudul di sini
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location.reload();
                        });
                    },
                    complete: function() {
                        tombolSimpan.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            $('#modal-tambah').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    <script>
      

            $(document).ready(function() {
            $('#example1').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');



                $.ajax({
                    method: 'GET',
                    url: '/users/' + id + '/edit',
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#name_edit').val(data.name);
                        $('#email_edit').val(data.email);
                        $('#role_edit').val(data.role);
                        $('#address_edit').val(data.address);
                        $('#description_edit').val(data.description);
                        $('#phone_number_edit').val(data.phone_number);
                        $('#wa_number_edit').val(data.wa_number);
                        $('#about_edit').val(data.about);
                        $('#website_edit').val(data.website);
                        $('#link_edit').val(data.link);
                        $('#shopee_edit').val(data.shopee);
                        $('#tokopedia_edit').val(data.tokopedia);
                        $('#bukalapak_edit').val(data.bukalapak);
                        $('#tiktok_edit').val(data.tiktok);
                        $('#instagram_edit').val(data.instagram);
                        $('#facebook_edit').val(data.facebook);
                        $('#youtube_edit').val(data.youtube);
                        $('#color_edit').val(data.color);
                        $('#status_edit').val(data.status);
                        $('#password_edit').val(data.password);

                        $('#picture_edit_container img').remove();
                        $('#picture_edit_container a').remove();

                        if (data.picture) {
                            var pictureImg = '<img src="/upload/user/' + data.picture +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var pictureLink = '<a href="/upload/user/' + data.picture +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#picture_edit_container').append(pictureImg + '<br>' +
                                pictureLink);
                        }

                        $('#avatar_edit_container img').remove();
                        $('#avatar_edit_container a').remove();

                        if (data.avatar) {
                            var avatarImg = '<img src="/upload/user/' + data.avatar +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var avatarLink = '<a href="/upload/user/' + data.avatar +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#avatar_edit_container').append(avatarImg + '<br>' + avatarLink);
                        }

                        $('#banner_edit_container img').remove();
                        $('#banner_edit_container a').remove();

                        if (data.banner) {
                            var bannerImg = '<img src="/upload/user/' + data.banner +
                                '" style="max-width: 200px; max-height: 200px;">';
                            var bannerLink = '<a href="/upload/user/' + data.banner +
                                '" target="_blank"><i class="fa fa-eye"></i> Lihat Gambar</a>';
                            $('#banner_edit_container').append(bannerImg + '<br>' + bannerLink);
                        }

                        $('#modal-edit').modal('show');
                        $('#id').val(id);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.statusText);
                    }
                });
            });

            $('#modal-edit').on('hidden.bs.modal', function() {
                $('#picture_edit_container img').remove();
                $('#picture_edit_container a').remove();
                $('#avatar_edit_container img').remove();
                $('#avatar_edit_container a').remove();
                $('#banner_edit_container img').remove();
                $('#banner_edit_container a').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#btn-save-edit').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-save-edit');
                var id = $('#id').val();
                var formData = new FormData($('#form-edit')[0]);

                $.ajax({
                    type: 'POST', // Gunakan POST karena kita override dengan PUT
                    url: '/users/' + id,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove();
                        tombolUpdate.prop('disabled', true);
                    },
                    success: function(response) {
                        $('#modal-edit').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    },
                    complete: function() {
                        tombolUpdate.prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status !== 422) {
                            $('#modal-edit').modal('hide');
                        }
                        var errorMessages = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errorMessages, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example1').on('click', '.btn-hapus', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah yakin akan menghapus data ?',
                    text: "data tidak bisa dikembalikan jika sudah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan permintaan AJAX ke endpoint penghapusan
                        $.ajax({
                            url: '/users/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('message') && response
                                    .message.includes(
                                        'terkait dengan mutasi_surat-keluar')) {
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.hasOwnProperty('message') &&
                                    response.message === 'Data Berhasil Dihapus') {
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed || result
                                            .isDismissed) {
                                            location
                                                .reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message ||
                                            'Gagal menghapus data',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data/masih terkait dengan tabel lain',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                console.log(xhr
                                    .responseText
                                ); // Tampilkan pesan error jika terjadi
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
