<!doctype html>
<html lang="{{ app()->getLocale() }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default"
      data-theme-colors="default">
<head>
    <meta charset="utf-8"/>
    <title>{{ setting('site.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="rogo.tr" name="author"/>
    <link rel="shortcut icon" href="{{ asset('assets/dashboard/images/favicon.ico') }}">
    <script src="{{ asset('assets/dashboard/js/layout.js') }}"></script>
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/dashboard/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body>

<div class="auth-page-wrapper pt-5">
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="{{ url()->current() }}" class="d-inline-block auth-logo">
                                <img src="{{ asset('storage/' . setting('site.logo_light')) }}" height="20">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 card-bg-fill">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">{{ __('Login') }}</h5>
                                <p class="text-muted">{{ __('Login Description') }}</p>
                            </div>
                            <div class="p-2 mt-4">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $message)
                                            {{ $message }}
                                        @endforeach
                                    </div>
                                @endif
                                <form action="{{ url()->current() }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="{{ __('Enter your email') }}" tabindex="1" autofocus required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="" class="text-muted">
                                                {{ __('Forgot password') }}
                                            </a>
                                        </div>
                                        <label class="form-label" for="password-input">
                                            {{ __('Password') }}
                                        </label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input"
                                                   name="password"
                                                   placeholder="{{ __('Enter your password') }}" id="password-input"
                                                   tabindex="2"
                                                   required>
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="auth-remember-check"
                                               tabindex="3">
                                        <label class="form-check-label" for="auth-remember-check">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit" tabindex="4">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            {{ date('Y') }} &copy; {{ setting('site.title') }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>
<script src="{{ asset('assets/dashboard/libs/particles.js/particles.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/pages/particles.app.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/pages/password-addon.init.js') }}"></script>
</body>

</html>
