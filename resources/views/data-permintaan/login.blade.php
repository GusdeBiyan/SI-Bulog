<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Bulog | Login User Kecamatan</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.webp" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>

    <link href="/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <script src="/sweetalert2/sweetalert2.min.js"></script>
</head>

<body>

    <style>
        .logo {
            width: auto;
            height: 40px;
        }
    </style>

    <!-- Content -->

    <div class="container-xxl">

        @if (session('toast_message'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                // Menampilkan toast dengan pesan dari session
                Toast.fire({
                    icon: "{{ session('toast_icon') }}",
                    title: "{{ session('toast_message') }}"
                });
            </script>
        @endif
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">

                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">


                            <img class="logo" src="/assets/img/icon.png" alt="">
                        </div>

                        <form id="formAuthentication" class="mb-3" action="{{ url('/login-kec') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ old('email') }}" id="email"
                                    name="email" placeholder="Enter your email" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>

                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <!-- <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/js/menu.js"></script> -->

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>


{{-- <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Data/</span> Permintaan Kec.
        {{ session('username') }}
</h4>


<div class="card mb-5">
    <div class="table-responsive">
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">

                <div class="btn-group ms-2">
                    <button class="btn btn-secondary dropdown-toggle btn-primary" tabindex="0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-start">
                        <a id="exportPrint" class="dropdown-item" href="#">Print<span><i class="bx bx-printer me-1"></i></span></a>
                        <a id="exportCsv" class="dropdown-item" href="#">Csv<span><i class="bx bx-file me-1"></i></span></a>
                        <a id="exportPdf" class="dropdown-item" href="#">Pdf<span><i class="bx bxs-file-pdf me-1"></i></span></a>
                    </div>
                </div>
            </div>
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Data Permintaan</th>
                        <th>Jumlah Beras</th>
                        <th>Jumlah RTS</th>


                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data_permintaan as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y ') }}
                        </td>

                        <td>{{ $item->data_permintaan }} </td>
                        <td>{{ number_format($item->jumlah_permintaan_beras, 0, ',', '.') }}
                            Kg
                        </td>
                        <td> {{ number_format($item->jumlah_rts, 0, ',', '.') }} Rts
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>


</div> --}}

</html>
