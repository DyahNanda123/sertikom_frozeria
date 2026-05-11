<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Frozeria</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            
            {{-- NAVBAR FIXED AT TOP --}}
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg text-primary"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right align-items-center">
                    {{-- <li class="mr-3 font-weight-bold text-primary d-none d-md-block">
                        <i class="far fa-clock mr-1"></i> <span id="clock">--:--</span>
                    </li> --}}
                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle nav-link-lg nav-link-user text-dark">
                            <img alt="image" src="https://ui-avatars.com/api/?name=Admin+Toko&background=6366f1&color=fff" class="rounded-circle mr-1 shadow-sm">
                            <div class="d-sm-none d-lg-inline-block font-weight-bold ml-1">Admin Toko</div>
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- SIDEBAR --}}
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-snowflake text-primary mr-2"></i>
                            <span>frozeria</span>
                        </a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route('dashboard') }}"><i class="fas fa-snowflake text-primary"></i></a>
                    </div>

                    <ul class="sidebar-menu mt-2">
                        <li class="menu-header">MENU UTAMA</li>
                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::is('kategori*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kategori.index') }}"><i class="fas fa-layer-group"></i> <span>Kategori</span></a>
                        </li>
                        <li class="{{ Request::is('bantuan') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bantuan') }}"><i class="fas fa-life-ring"></i> <span>Bantuan</span></a>
                        </li>
                    </ul>
                </aside>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="main-content">
                @yield('content')
            </div>

            {{-- FOOTER --}}
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2026 <div class="bullet"></div> Frozeria Stok Opname
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <script>
        function updateTime() {
            const now = new Date();
            const clockEl = document.getElementById('clock');
            if (clockEl) {
                clockEl.textContent = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            }
        }
        updateTime(); 
        setInterval(updateTime, 60000);
    </script>

    @yield('scripts')

</body>
</html>