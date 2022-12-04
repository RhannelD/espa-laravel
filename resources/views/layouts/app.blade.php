<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('niceadmin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('niceadmin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('niceadmin/css/style.css') }}" rel="stylesheet">

    @livewireStyles
    @livewireScripts

    <script defer src="{{ asset('js/app.js') }}"></script>
    <script defer src="{{ asset('niceadmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script defer src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script defer src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script defer src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script defer src="{{ asset('js/alpinejs.min.js') }}"></script>
</head>

<body>
    <!-- ======= Header ======= -->
    @include('layouts.sub.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('layouts.sub.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">
        <!-- Start Page Title -->
        @include('layouts.sub.pagetitle')
        <!-- End Page Title -->

        <section class="section">
            @yield('content')
        </section>
    </main>

    <!-- ======= Footer ======= -->
    {{-- @include('layouts.sub.footer') --}}
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script>
    <script src="{{ asset('niceadmin/js/main.js') }}"></script>

    <script>
        window.addEventListener('swal:modal', event => { 
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('redirect-blank', event => {
            window.open(event.detail.url, '_blank'); 
		});

        window.addEventListener('modal-toggle', event => {
			$("#"+event.detail.id).modal(event.detail.action);
		});

        window.addEventListener('scroll-to-top', event => {
            window.scrollTo({top: 0, behavior: 'smooth'});
		});
    </script>
    @if ( session()->has('alert_success') )
        <script id="alert_success">
            swal({
                title: "{{ session()->get('alert_success')['messsage'] }}",
                text:  "{{ session()->get('alert_success')['text'] }}",
                icon: 'success',
            });
            $("#alert_success").remove();
        </script>
    @endif
    @if ( session()->has('alert_info') )
        <script id="alert_info">
            swal({
                title: "{{ session()->get('alert_info')['messsage'] }}",
                text:  "{{ session()->get('alert_info')['text'] }}",
                icon: 'info',
            });
            $("#alert_info").remove();
        </script>
    @endif
    @if ( session()->has('alert_error') )
        <script id="alert_error">
            swal({
                title: "{{ session()->get('alert_error')['messsage'] }}",
                text:  "{{ session()->get('alert_error')['text'] }}",
                icon: 'error',
            });
            $("#alert_error").remove();
        </script>
    @endif
</body>

</html>