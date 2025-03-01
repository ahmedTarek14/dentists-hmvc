<!DOCTYPE html>
<html lang="{{ locale() }}" class="light" dir="{{ locale() == 'en' ? 'ltr' : 'rtl' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __('auth::common.login_title') }} | Dens Tech</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ aurl('img/favicon.png') }}">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

    <!-- CSS Files -->
    @if (locale() == 'en')
        <link id="pagestyle" href="{{ aurl('css/soft-ui-dashboard.min.css') }}" rel="stylesheet" />
    @else
        <link id="pagestyle" href="{{ aurl('css/soft-ui-dashboard-rtl.min.css') }}" rel="stylesheet" />
    @endif

</head>

<body class="bg-light">
    <main class="main-content mt-0">
        <section class="min-vh-100 d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header text-center bg-gradient-info text-white">
                                <h3 class="font-weight-bold">{{ __('auth::common.welcome_back') }}</h3>
                                <p class="mb-0">{{ __('auth::common.login_subtitle') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.login') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ __('auth::common.username') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="{{ __('auth::common.enter_username') }}" required>
                                        @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ __('auth::common.password') }}</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="{{ __('auth::common.enter_password') }}" required>
                                        @error('password')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-5">
                                        <button type="submit"
                                            class="btn bg-gradient-info w-100">{{ __('auth::common.sign_in') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <p class="mb-0">
                                    {{ __('auth::common.no_account') }}
                                    <a href="#" class="text-info">{{ __('auth::common.sign_up') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="h-100 w-100 bg-cover rounded-end"
                            style="background: url('{{ aurl('img/curved-images/curved6.png') }}') center/contain no-repeat;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Language Switcher -->
    <div class="position-absolute top-0 end-0 mt-3 me-3">
        <div class="dropdown">
            <button class="btn btn-info dropdown-toggle px-3 py-2 rounded-pill shadow-sm" type="button"
                id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                🌍 {{ __('auth::common.language') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li>
                        <a class="dropdown-item text-center fw-bold"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ aurl('js/core/popper.min.js') }}"></script>
    <script src="{{ aurl('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ aurl('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ aurl('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
                damping: '0.5'
            });
        }
    </script>
</body>

</html>
