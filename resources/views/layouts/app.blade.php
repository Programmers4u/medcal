<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ isset($business) ? $business->name . ' / ' : '' }}{{ trans('app.name') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    
    <link rel="manifest" href="/manifest.json">

    <script type="text/javascript" src="/js/rollbar.min.js"></script>
    <script src="{{ asset('js/lib/utils.js') }}"></script>
    <script type="text/javascript" src="/js/alert/alert.min.js"></script>
    <script type="text/javascript" src="/js/confirm/confirm.min.js"></script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('css')

@yield('headscripts')

@stack('header_scripts')

{!! Analytics::render() !!}

</head>

<body class="skin-purple-light sidebar-mini sidebar-collapse">

    <div class="wrapper">
          
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>m</b>c</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">Med<b>Cal</b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                {{-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a> --}}
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav mr-auto">
                       <!-- Search Menu Here -->
                        @include('_user-search-menu')                     
                            
                        <!--
                        @include('_navi18n')

                        @include('user._navmenu')
                           -->
                       
                        <!-- Messages Notifications Here-->

                        <!-- Notifications Menu Here -->

                        <!-- Tasks Menu Here -->
                        @include('_user-task-menu')

                        <!-- User Account Menu -->
                        @include('_user-account-menu')

                        <!-- Control Sidebar Toggle Button -->
                        <!--
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                        -->
                    </ul>
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                @if(isset($business))

                <!-- Sidebar user panel (optional) -->
                @include('manager._sidebar-userpanel', compact('business'))

                <!-- search form (Optional) -->
                @include('manager._search', compact('business'))
                <!-- /.search form -->

                <!-- Sidebar Menu -->
                @include('manager._sidebar-menu', compact('business'))

                @endif

                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('title', '')
                    <small>@yield('subtitle', '')</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Your Page Content Here -->
                @include('flash::message')
                @include('_errors')

                @yield('content')

                @if(!session()->has('selected.business'))
                    <center>
                    {!! Button::success(trans('app.btn.get_to_dashboard'))
                                ->asLinkTo( route('manager.business.index') ) !!}
                    </center>
                @endif

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('_footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-light">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-userhelp-tab" data-toggle="tab"><i class="fa fa-question"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-userhelp-tab">
                    <h3 class="control-sidebar-heading">{{ trans('app.nav.help') }}</h3>
                    {!! $help !!}
                    <!-- /.control-sidebar-menu -->

                </div>
                <!-- /.tab-pane -->
                <!-- Stats tab content -->
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Report panel usage
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>Some information about this general settings option</p>
                        </div>
                        <!-- /.form-group -->
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
        </aside>
        <!-- /.control-sidebar -->

    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>

@stack('footer_scripts')

<script type="text/javascript">
$(document).ready(function() {
    $('.btn').tooltipster({ animation: "grow", theme: 'tooltipster-light' });
    // Menu Toggle Script
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    //$(".sidebar-toggle").click();
});
</script>


<div class="modal" id="alertModal" tabindex="1" style="z-index:1000000;" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gainsboro;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="alertModalLabel">Informacja</h3>
            </div>
            <div class="modal-body">
                <div style="display:none;" id="mc_info_success" class="alert alert-success"></div>
                <div style="display:none;" id="mc_info_error" class="alert alert-danger"></div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="confirmModal" tabindex="1" style="z-index:1000000;" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gainsboro;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="confirmModalLabel">Potwierdź</h3>
            </div>
            <div class="modal-body">
                <div style="display:none;" id="confirm_info_success" class="alert alert-success"></div>
                <div style="display:none;" id="confirm_info_error" class="alert alert-danger"></div>
            </div>
        </div>
    </div>
  </div>
</div>

</body>
</html>
