<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">Dashboard</li>
                @stack('breadcrumb')
            </ol>
            <h6 class="font-weight-bolder mb-0">@stack('title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-auto d-flex align-items-center"> <!-- ضبط المحاذاة -->
                <!-- زر تغيير اللغة -->
                <li class="nav-item dropdown me-3">
                    <button class="btn btn-outline-info dropdown-toggle px-3 py-2 rounded-pill" type="button"
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
                </li>

                <!-- زر تسجيل الخروج -->
                <li class="nav-item">
                    <a href="javascript:;" onclick="$('#logout-form').submit()"
                        class="btn btn-danger px-3 py-2 rounded-pill">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        <span>{{ __('auth::common.logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<form method="post" action="{{ route('admin.logout') }}" id="logout-form">
    @csrf
</form>
