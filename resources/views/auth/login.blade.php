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
        <div class="row">
            <div class="col-8 d-flex justify-content-center align-items-center min-vh-100">
                {{-- form --}}
                <div class="container px-8 bg-white">
                    <h2 class="text-primary fw-bold mb-5 text-center">Sign In</h2>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-sm"
                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>

                        <div class="input-group mt-4">
                            <input id="password" type="password" name="password" class="form-control form-control-sm"
                                placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                            <span class="input-group-text"><i class="fa-regular fa-eye-slash" id="toggle-pw" style="cursor: pointer;"></i></span>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>
                        <div class="d-grid">
                            <button type="submit"
                                class="btn btn-primary rounded btn-lg mt-4 fs-6">{{ __('Masuk') }}</button>
                        </div>
                        <div class="form-group form-check mt-4 text-start">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" for="exampleCheck1">I agree to the <a href="#">Master
                                    Subscription Agreement</a></label>
                        </div>
                    </form>
                </div>
                {{-- form --}}
            </div>

            <div class="col-4 bg-primary d-flex d-flex justify-content-center align-items-center text-center">
                <div class="mt-2 text-white">
                    <h2 class="fw-bold">Don't have an account ?</h2>
                    <p>Create your account !</p>
                    <div class="d-grid">
                        <a class="btn btn-outline-light btn-lg rounded mx-5 fs-6" href="{{ route('register') }}">Sign
                            Up</a>
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
