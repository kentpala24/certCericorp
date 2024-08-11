<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SCertificado Digital - CERTESTING PERU">
    <meta name="author" content="www.cicbla.com">
    <meta name="keyword" content="Certificado Digital - CERTESTING PERU">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>CERICORP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
    
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Desk</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Settings</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notifications</strong>
                    </div>
                    <a class="dropdown-item" @click="menu=3">
                        <i class="fa fa-envelope-o"></i> Request Approval
                    </a>
                    <a class="dropdown-item" @click="menu=5">
                        <i class="fa fa-tasks"></i> Batch  Authorization
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        @if(Auth::check())
            @if(Auth::user()->idrol==1)
                @include('plantilla.sidebaradministrador')
            @elseif(Auth::user()->idrol==2)
                @include('plantilla.sidebarautorizador')
            @elseif(Auth::user()->idrol==3)
                @include('plantilla.sidebarrevisor')
            @elseif(Auth::user()->idrol==4)
                @include('plantilla.sidebaraprobador')
            @elseif(Auth::user()->idrol==5)
                @include('plantilla.sidebarcertificaciones')
            @elseif(Auth::user()->idrol==6)
                @include('plantilla.sidebarcicb')
            @endif
        
        @endif


        <!-- Contenido Principal -->
        @yield('contenido')
        <!-- /Fin del contenido principal -->
    </div>

    
    </div>
    <footer class="app-footer">
        <span><a href="https://certestingperu.com/">CERICORP</a> &copy; {{date("Y")}}</span>
        <span class="ml-auto">Developed by <a href="https://certestingperu.com/">KGPS</a></span>
    </footer>

    <script src="js/app.js"></script>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/qrcode.min.js"></script>
    <script src="js/plantilla.js"></script>
    
</body>

</html>