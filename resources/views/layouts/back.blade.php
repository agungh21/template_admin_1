<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="_token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <link href="{{ url('vendors/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('vendors/elegant/css/style.css') }}">

    <link rel="stylesheet" href="{{ url('vendors/fontawesome/all.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/select2-atlantis.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/ladda/ladda-themeless.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/jquery-confirm/jquery-confirm.css') }}">

    <link rel="stylesheet" href="{{ url('vendors/datatables/datatables.min.css') }}">

    <style>
         .transparent-bg {
            position: absolute;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            width: 100%;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(250, 250, 250, 0.5);
            color: white;
            text-align: center;
            z-index: 1;
        }

    </style>

    @yield('styles')

</head>

<body class="hold-transition sidebar-mini">
    <div id="loading"></div>

    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
      <!-- ! Sidebar -->
      @include('layouts.sidebar')
      <div class="main-wrapper">
        <!-- ! Main nav -->
        @include('layouts.main-nav')

        <!-- ! Main -->
        <main class="main users chart-page" id="skip-target">
            <div class="container-fluid">
                @yield('content-back')
            </div>
          </main>

        <!-- ! Sidebar menu -->
        @yield('modal')

        <!-- ! Footer -->
        @include('layouts.footer')
      </div>
    </div>

    <script src="{{ url('vendors/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('vendors/elegant/js/script.js') }}"></script>
    <script src="{{ url('vendors/elegant/plugins/chart.min.js') }}"></script>
    <script src="{{ url('vendors/elegant/plugins/feather.min.js') }}"></script>

    <script src="{{ url('vendors/jquery/jquery.min.js') }}"></script>

    <script src="{{ url('vendors/fontawesome/all.js') }}"></script>
    <script src="{{ url('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ url('vendors/ladda/spin.min.js') }}"></script>
    <script src="{{ url('vendors/ladda/ladda.min.js') }}"></script>
    <script src="{{ url('vendors/ladda/ladda.jquery.min.js') }}"></script>
    <script src="{{ url('vendors/jquery-confirm/jquery-confirm.js') }}"></script>
    <script src="{{ url('vendors/bootstrap-5-toast-snackbar/src/toast.js') }}"></script>

    <script src="{{ url('assets/js/myJs.js') }}"></script>
    <script>
        $(window).on('load', function() {
            const loading = $('#loading');
            loadingPage(loading);
        });
        $(document).ready(function() {
            var url = window.location.href;

            $('ul.sidebar-body-menu a').filter(function() {

                if(this.href != url) {
                    $(this).removeClass('visible');
                    $(this).removeClass('active');
                }

                return this.href == url;
            }).addClass('active');

            // for treeview
            $('ul.cat-sub-menu a').filter(function() {
                return this.href == url;
            }).parentsUntil(".sidebar-body-menu > .cat-sub-menu").addClass('visible').prev('a').addClass('active');
        });

    </script>

    @if(session()->has('success'))
    <script>
        $(document).ready(function() {
            let message = `{!! \Session::get('success') !!}`;
            successNotificationSnack(message);
        })
    </script>
    @endif

    @yield('scripts')
</body>

</html>
