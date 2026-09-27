<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('corona/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('corona/vendors/css/vendor.bundle.base.css') }}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('corona/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('corona/images/favicon.png') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
    <style>
      .sidebar-brand-wrapper img {
          max-width: 100%;
          height: auto;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo text-white font-weight-bold text-decoration-none" href="{{ route('dashboard') }}">
              <img src="{{ asset('Bank_BRI_2000.svg') }}" alt="logo" style="max-height: 35px; width: auto; max-width: 100%; object-fit: contain;" />
          </a>
          <a class="sidebar-brand brand-logo-mini text-white font-weight-bold text-decoration-none" href="{{ route('dashboard') }}">
              <img src="{{ asset('Bank_BRI_2000.svg') }}" alt="logo" style="max-height: 30px; width: auto; object-fit: contain;" />
          </a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <div class="img-xs rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold">
                      {{ substr(auth()->user()->name, 0, 1) }}
                  </div>
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">{{ auth()->user()->name }}</h5>
                  <span>{{ ucfirst(auth()->user()->role) }}</span>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('work-units.*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#master-data" aria-expanded="{{ request()->routeIs('work-units.*') ? 'true' : 'false' }}" aria-controls="master-data">
              <span class="menu-icon">
                <i class="mdi mdi-database"></i>
              </span>
              <span class="menu-title">Master Data</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('work-units.*') ? 'show' : '' }}" id="master-data">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link {{ request()->routeIs('work-units.*') ? 'active' : '' }}" href="{{ route('work-units.index') }}">Unit Kerja</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item menu-items {{ request()->routeIs('devices.computers', 'devices.laptops', 'devices.printers') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#inventaris-aset" aria-expanded="{{ request()->routeIs('devices.computers', 'devices.laptops', 'devices.printers') ? 'true' : 'false' }}" aria-controls="inventaris-aset">
              <span class="menu-icon">
                <i class="mdi mdi-monitor-dashboard"></i>
              </span>
              <span class="menu-title">Inventaris Aset</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('devices.computers', 'devices.laptops', 'devices.printers') ? 'show' : '' }}" id="inventaris-aset">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link {{ request()->routeIs('devices.computers') ? 'active' : '' }}" href="{{ route('devices.computers') }}">Komputer</a></li>
                <li class="nav-item"> <a class="nav-link {{ request()->routeIs('devices.laptops') ? 'active' : '' }}" href="{{ route('devices.laptops') }}">Laptop</a></li>
                <li class="nav-item"> <a class="nav-link {{ request()->routeIs('devices.printers') ? 'active' : '' }}" href="{{ route('devices.printers') }}">Printer</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items {{ request()->routeIs('documents.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('documents.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Berkas & Dokumen</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini text-white font-weight-bold text-decoration-none" href="{{ route('dashboard') }}">BRI</a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <div class="img-xs rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <p class="mb-0 d-none d-sm-block navbar-profile-name ml-2">{{ auth()->user()->name }}</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="{{ route('profile.edit') }}">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <a class="dropdown-item preview-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="preview-thumbnail">
                          <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-logout text-danger"></i>
                          </div>
                        </div>
                        <div class="preview-item-content">
                          <p class="preview-subject mb-1">Log out</p>
                        </div>
                      </a>
                  </form>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
             @if (isset($header))
                 <div class="page-header">
                     <h3 class="page-title"> {{ $header }} </h3>
                 </div>
             @endif
             
             @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "{{ session('success') }}",
                            showConfirmButton: false,
                            timer: 2500,
                            background: '#191c24',
                            color: '#ffffff'
                        });
                    });
                </script>
             @endif

             @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: "{{ session('error') }}",
                            showConfirmButton: true,
                            background: '#191c24',
                            color: '#ffffff'
                        });
                    });
                </script>
             @endif

             {{ $slot }}
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © INVENTORY BRI JEMBER 2026</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('corona/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('corona/js/off-canvas.js') }}"></script>
    <script src="{{ asset('corona/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('corona/js/misc.js') }}"></script>
    <script src="{{ asset('corona/js/settings.js') }}"></script>
    <!-- endinject -->
    @stack('scripts')
  </body>
</html>
