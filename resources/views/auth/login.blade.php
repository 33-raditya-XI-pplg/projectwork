<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
</head>

<body>

    <div class="container-fluid bg-white">
        <div class="row min-vh-100">
            {{-- <div class="col-md-8 d-flex justify-content-center align-items-center"> --}}
            <div class="col-md-7 d-flex justify-content-center align-items-center">
                {{-- form --}}
                <div class="container mx-md-7 bg-white">
                    <div class="title mb-5">
                        <a href="/"><img class="mt-3 top-0 start-0 mb-5" src="{{ asset('assets/img/logo.png') }}" width="40%" alt="logo"></a>
                        <h2 class=""><b> Login </b></h2>
                        <p>Buat kamu yang sudah terdaftar, silakan masuk ke akunmu.</p>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for=""><b> Email </b></label>
                            <input type="email" name="email" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>
                        <div class="mb-4">
                            <label for=""><b> Password </b></label>
                            <div class="input-group">
                                <input id="password" type="password" name="password" class="form-control"
                                    placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                <span class="input-group-text bg-transparent"><i class="fa-regular fa-eye-slash"
                                        id="toggle-pw" style="cursor: pointer;"></i></span>
                                
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>
                        <div class="d-grid">
                            <button type="submit"
                                class="btn btn-primary rounded mt-4">{{ __('Login') }}</button>
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

            <div class="col-md-5 d-flex flex-column justify-content-center position-relative" style="background: url({{ asset('assets/img/bg-login.png') }});background-size: cover;background-repeat: no-repeat;">
                <div id="content" class="container text-white text-center">
                    <h2 class="fw-bold">Belum Memiliki Akun ?</h2>
                    <p>Ayo, Registrasi Sekarang!</p>
                    <div class="d-grid">
                        <a class="btn btn-outline-light btn-lg rounded mx-6 fs-6" href="{{ route('register') }}">Registrasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    let pw = document.getElementById("password");
    let eye = document.getElementById("toggle-pw");

    eye.onclick = function() {
        if (pw.type == "password") {
            pw.type = "text";
            eye.className = "fa-regular fa-eye";
        } else {
            pw.type = "password";
            eye.className = "fa-regular fa-eye-slash";
        }
    }
</script>

</html>
