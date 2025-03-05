<!DOCTYPE html>
<html lang="{{ locale() }}" class="light" dir="{{ locale() == 'en' ? 'ltr' : 'rtl' }}">
@include('layouts.head')

<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        /* يخلي الصفحة بارتفاع الشاشة بالكامل */
    }

    .container-fluid {
        flex: 1;
    }
</style>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.modals')
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @include('layouts.nav')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>
        @include('layouts.footer')
    </main>
    @include('layouts.script')
</body>

</html>
