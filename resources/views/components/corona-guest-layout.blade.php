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
    <style>
      .login-bg {
        background: url('{{ asset('corona/images/auth/login-bg.jpg') }}') no-repeat center center;
        background-size: cover;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5 text-center">
                <img src="{{ asset('Bank_BRI_2000.svg') }}" alt="logo" class="mb-4" style="max-width: 200px;" />
                {{ $slot }}
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
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
  </body>
</html>
