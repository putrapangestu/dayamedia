
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="keywords" content="Penerbit Azzia" />
  @stack('meta')

  <link rel="shortcut icon" type="image/png" href="{{ asset('') }}assets/azzia-logo.png" />

  <!-- Core Css -->
  {{-- <link rel="stylesheet" href="{{ asset('') }}assets/dashboard/css/styles.css" /> --}}
  <link rel="stylesheet" href="{{ asset('') }}assets/dashboard/css/styles.css" />

  <title>Penerbit Azzia</title>
  <!-- Owl Carousel  -->
  <link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/owl.carousel/dist/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="{{ asset('') }}assets/dashboard/libs/sweetalert2/dist/sweetalert2.min.css">

  @stack('css')
</head>

<body>


    <!-- Preloader -->
  <!-- LOADER -->
  <div class="preloader">
      <div class="lds-ellipsis">
          <span></span>
          <span></span>
          <span></span>
      </div>
  </div>
  <!-- END LOADER -->
  <!-- ------------------------------------- -->
  <!-- Top Bar Start -->
  <!-- ------------------------------------- -->
  <div class="topbar-image bg-primary py-1 rounded-0 mb-0 alert alert-dismissible fade show" role="alert">
    <div class="d-flex justify-content-center gap-sm-3 gap-2 align-items-center text-center flex-md-nowrap flex-wrap">
      <p class="mb-0 text-white fw-bold">Selamat Datang di Azzia</p>
    </div>
    <button type="button" class="btn-close btn-close-white p-2 fs-2" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <!-- ------------------------------------- -->
  <!-- Top Bar End -->
  <!-- ------------------------------------- -->

  <!-- ------------------------------------- -->
  <!-- Header Start -->
  <!-- ------------------------------------- -->
  @include('landing.partials.header')
  <!-- ------------------------------------- -->
  <!-- Header End -->
  <!-- ------------------------------------- -->

  <!-- ------------------------------------- -->
  <!-- Responsive Sidebar Start -->
  <!-- ------------------------------------- -->
  @include('landing.partials.mobile-menu')
  <!-- ------------------------------------- -->
  <!-- Responsive Sidebar End -->
  <!-- ------------------------------------- -->
  @yield('content')

  <!-- ------------------------------------- -->
  <!-- Footer Start -->
  <!-- ------------------------------------- -->
    @include('landing.partials.footer')
  <!-- ------------------------------------- -->
  <!-- Footer End -->
  <!-- ------------------------------------- -->

  <!-- Scroll Top -->
  <a href="javascript:void(0)" class="top-btn btn btn-primary d-flex align-items-center justify-content-center round-54 p-0 rounded-circle">
    <i class="ti ti-arrow-up fs-7"></i>
  </a>
  <script src="{{ asset('') }}assets/dashboard/js/vendor.min.js"></script>
  <!-- Import Js Files -->
  <script src="{{ asset('') }}assets/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('') }}assets/dashboard/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="{{ asset('') }}assets/dashboard/js/theme/app.init.js"></script>
  <script src="{{ asset('') }}assets/dashboard/js/theme/theme.js"></script>
  <script src="{{ asset('') }}assets/dashboard/js/theme/app.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ asset('') }}assets/dashboard/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="{{ asset('') }}assets/dashboard/js/frontend-landingpage/homepage.js"></script>
  <script src="{{ asset('') }}assets/dashboard/libs/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="{{ asset('') }}assets/dashboard/js/plugins/toastr-init.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
        // Function to update cart count (Globally accessible)
        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                method: 'GET',
                success: function(response) {
                    const cartBadge = $('.btn[href="{{ route("cart") }}"] .badge');
                    if (response.count > 0) {
                        if (cartBadge.length) {
                            cartBadge.text(response.count);
                        } else {
                            $('.btn[href="{{ route("cart") }}"]').append(
                                '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">' +
                                response.count +
                                '</span>'
                            );
                        }
                    } else {
                        cartBadge.remove();
                    }
                },
                error: function() {
                    console.log('Error updating cart count');
                }
            });
        }

        $(document).ready(function () {
            @if (Session::has('success'))
                toastr.success(
                    "{{ Session::get('success') }}",
                    "Berhasil",
                    { showMethod: "fadeIn", hideMethod: "fadeOut", timeOut: 2000, closeButton: true, }
                );
            @endif

            @if (Session::has('error'))
                toastr.error(
                    "{{ Session::get('error') }}",
                    "Gagal",
                    { showMethod: "fadeIn", hideMethod: "fadeOut", timeOut: 2000, closeButton: true, }
                );
            @endif

            // Update cart count on page load
            @auth
                updateCartCount();
                // Update every 30 seconds
                setInterval(updateCartCount, 30000);
            @endauth
        });
    </script>

  @stack('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.toggle-password', function() {
                const target = $(this).data('target');
                const input = $(target);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });
        });
    </script>
</body>

</html>
