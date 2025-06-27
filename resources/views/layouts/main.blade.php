<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ Session::token() }}">
    <meta name="userID" content="{{ Auth::user()->id }}">
    <meta name="userNIP" content="{{ Auth::user()->nip }}">
    @yield('style')
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="/vendor/DataTables/DataTables-1.13.8/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="/vendor/bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/sidebar/style.css">
    @yield('style2')


    <!----===== Boxicons CSS ===== -->
    <link rel="stylesheet" href="/vendor/boxicons-2.1.4/css/boxicons.min.css">

        <link rel="shortcut icon" href="/clinic_icon.png" type="image/x-icon">

    <title>Dashboard Sidebar Menu</title>
</head>

<body class="{{Auth::user()->darkMode == '1' ? 'dark' : ''}}">
    <?php $loggedID = Auth::user()->id?>
    @include('layouts.sidebar')

    <section class="home d-flex justify-content-center">

        @yield('body')


    </section>

    <script type="text/javascript" src="/vendor/jquery-3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/js/sidebar/script.js"></script>


    <script src="/vendor/DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>

    {{-- <script src="http://{{$_SERVER['HTTP_HOST']}}/boxicons/boxicons.js"></script> --}}
    <?php
        echo "<script type=\"text/javascript\">";
        echo "var appURL = \"".env("APP_URL", "localhost")."\";";
        echo "</script>";
    ?>

    @yield('script')
</body>
