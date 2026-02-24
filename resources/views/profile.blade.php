@extends('master')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">



                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle"></i> Edit Profil</h5>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            {{-- @method('PUT') --}}

                            <h6 class="text-uppercase text-secondary mb-3">Informasi Dasar</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required>
                            </div>

                            <hr class="my-4">

                            <h6 class="text-uppercase text-secondary mb-3">Keamanan (Kosongkan jika tidak ingin mengubah)
                            </h6>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Minimal 8 karakter">
                                    <span class="input-group-text" style="cursor:pointer"
                                        onclick="togglePassword('password', this)">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Ulangi password baru">
                                    <span class="input-group-text" style="cursor:pointer"
                                        onclick="togglePassword('password_confirmation', this)">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                {{-- <button type="reset" class="btn btn-light me-md-2">Reset</button> --}}
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }

        /* validasi sebelum submit */
        document.querySelector('form').addEventListener('submit', function(e) {

            const pass = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;

            // kalau dua-duanya diisi
            if (pass !== '' || conf !== '') {
                if (pass !== conf) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'error',
                        title: 'Password tidak sama',
                        text: 'Konfirmasi password harus sama dengan password baru.'
                    });
                }
            }

        });
    </script>
@endsection
