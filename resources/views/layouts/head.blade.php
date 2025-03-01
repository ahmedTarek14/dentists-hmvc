<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ aurl('img/favicon.png') }}">
    <title>
        @stack('title') | Dens Tech
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    @if (locale() == 'en')
        <link id="pagestyle" href="{{ aurl('css/soft-ui-dashboard.min.css') }}" rel="stylesheet" />
    @else
        <link id="pagestyle" href="{{ aurl('css/soft-ui-dashboard-rtl.min.css') }}" rel="stylesheet" />
    @endif

    @stack('css')
</head>
