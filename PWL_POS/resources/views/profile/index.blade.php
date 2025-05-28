@extends('layouts.template')

@section('content')
    <div class="row">

        <!-- Kolom Tengah (Avatar & Upload) -->
        <div class="col-md-4 offset-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid" src="{{ $user->foto_profil }}" alt="User profile picture"
                            style="width: 209px; height: 209px;">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                    <form action="{{ route('profile.avatar') }}" id="avatarForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                                    id="avatar" name="avatar" accept="image/*">
                                <label class="custom-file-label" for="avatar" id="avatar-label">Pilih file</label>
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update Foto Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        document.getElementById("avatar").addEventListener("change", function() {
            let fileName = this.files[0] ? this.files[0].name : "Pilih file";
            document.getElementById("avatar-label").innerText = fileName;
        });

        document.getElementById('avatarForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            document.querySelector('.profile-user-img').src = data.new_avatar_url;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengupload avatar'
                    });
                    console.error('Error:', error);
                });
        });
    </script>
@endpush
