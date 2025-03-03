<!DOCTYPE html>
<html lang="{{ locale() }}" class="light" dir="{{ locale() == 'en' ? 'ltr' : 'rtl' }}">
@include('layouts.head')


<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('content')
            @include('layouts.footer')
        </div>
    </main>
    <!--   Core JS Files   -->
    @include('layouts.script')
</body>

</html>
