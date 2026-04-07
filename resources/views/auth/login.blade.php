@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">

                <div class="brand-logo">
                    <h1>Zaylish Studio</h1>
                </div>

                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>

                <form class="pt-3" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <input type="email"
                               class="form-control form-control-lg"
                               placeholder="Username"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus>

                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Password with Eye Icon -->
                    <div class="form-group position-relative">

                        <input type="password"
                               class="form-control form-control-lg"
                               id="password"
                               placeholder="Password"
                               name="password"
                               required
                               autocomplete="current-password">

                        <!-- Eye Icon -->
                        <span onclick="togglePassword()"
                              style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                            <i id="toggleIcon" class="mdi mdi-eye"></i>
                        </span>

                        @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <!-- Login Button -->
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                            SIGN IN
                        </button>
                    </div>

                    <!-- Register -->
                    <div class="mb-2 mt-3">
                        <a href="{{ route('register') }}"
                           class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                            Create an account
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Show/Hide Password Script -->
<script>
function togglePassword() {

    const passwordField = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("mdi-eye");
        icon.classList.add("mdi-eye-off");
    } else {
        passwordField.type = "password";
        icon.classList.remove("mdi-eye-off");
        icon.classList.add("mdi-eye");
    }

}
</script>

@endsection
