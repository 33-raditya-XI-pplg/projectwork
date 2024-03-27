<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
</head>

<body>

    <div class="container-fluid bg-white">
        <div class="row min-vh-100">
            <div class="col-md-5 bg-primary d-flex flex-column justify-content-center position-relative" style="background: url({{ asset('assets/img/bg-register.png') }});background-size: cover;background-repeat: no-repeat;">
                {{-- <a href="/"><img class="position-absolute mt-3 top-0 start-0 ms-4" src="{{ asset('assets/img/logo2.png') }}" height="35" alt="logo"></a> --}}
                <div class="container mt-2 text-white text-center">
                    <h2 class="fw-bold">Selamat datang kembali!</h2>
                    <p>Jika sudah punya akun anda bisa langsung login</p>
                    <div class="d-grid">
                        <a class="btn btn-outline-light btn-lg mx-6 rounded fs-6" href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>

            <div class="col-md-7 d-flex justify-content-center align-items-center">
                {{-- form --}}
                <div class="container mx-md-7 bg-white">
                    <div class="text-center">
                        <a href="/"><img class="mt-3 top-0 start-0 mb-3 text-center" src="{{ asset('assets/img/logo.png') }}" width="40%" alt="logo"></a>
                        <h2 class="fw-bold mb-3 mt-3 text-center">Registrasi</h2>
                    </div>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="nama" name="nama_lengkap" class="form-control form-control-sm"
                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Lengkap" required>
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2 text-danger" />
                        </div>
                        <div class="form-group mt-4">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm"
                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>
                        <div class="form-group mt-4">
                            <label for="">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" name="password" class="form-control form-control-sm"
                                    placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                <span class="input-group-text bg-transparent"><i class="fa-regular fa-eye-slash" id="toggle-pw" style="cursor: pointer;"></i></span>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <label for="">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm "
                                id="password2" placeholder="Konfirmasi Password" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="d-grid">
                            <button type="submit"
                                class="btn btn-primary rounded btn-lg mt-4 fs-6">{{ __('Registrasi') }}</button>
                        </div>
                        {{-- <div class="form-group form-check mt-4 text-start">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" for="exampleCheck1">I agree to the <a href="#">Master
                                    Subscription Agreement</a></label>
                        </div> --}}
                    </form>
                </div>
                {{-- form --}}
            </div>
            
        </div>
    </div>
</body>

<script>
    let pw = document.getElementById("password");
    let pw2 = document.getElementById("password2");
    let eye = document.getElementById("toggle-pw");

    eye.onclick = function() {
        if (pw.type == "password") {
            pw.type = "text";
            pw2.type = "text";
            eye.className = "fa-regular fa-eye";
        } else {
            pw.type = "password";
            pw2.type = "password";
            eye.className = "fa-regular fa-eye-slash";
        }
    }
</script>

</html>

