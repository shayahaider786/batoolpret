@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-form-light text-left p-5">

                <div class="brand-logo">
                    <h1>Zaylish Studio</h1>
                </div>

                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Create an account to continue.</h6>

                <form class="pt-3" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <input type="text"
                               class="form-control form-control-lg"
                               placeholder="Name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autocomplete="name"
                               autofocus>

                        @error('name')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input type="email"
                               class="form-control form-control-lg"
                               placeholder="Email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group position-relative">

                        <input type="password"
                               class="form-control form-control-lg"
                               id="password"
                               placeholder="Password"
                               name="password"
                               required
                               autocomplete="new-password">

                        <span onclick="togglePassword('password','icon1')"
                              style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                            <i id="icon1" class="mdi mdi-eye"></i>
                        </span>

                        @error('password')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group position-relative">

                        <input type="password"
                               class="form-control form-control-lg"
                               id="confirm_password"
                               placeholder="Confirm Password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password">

                        <span onclick="togglePassword('confirm_password','icon2')"
                              style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                            <i id="icon2" class="mdi mdi-eye"></i>
                        </span>

                        @error('password_confirmation')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <!-- Register Button -->
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                            REGISTER
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Show/Hide Password Script -->
<script>
function togglePassword(fieldId, iconId) {

    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);

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
