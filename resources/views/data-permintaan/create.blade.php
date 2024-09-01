<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Bulog | Data Permintaan Kec {{ session('username') }}</title>

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
    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">



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
        .icon {
            width: 100px;
            height: auto;
        }

        .swal2-container {
            z-index: 99999;
            /* Atur z-index SweetAlert menjadi tinggi */
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <a href="#" class="app-brand-link">
                <img class="icon" src="/assets/img/icon.png" alt="">
            </a>
            {{--
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div> --}}

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


                <ul class="navbar-nav flex-row align-items-center ms-auto">


                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="/assets/img/avatars/1.png" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="fw-medium d-block">{{ session('nama_penanggung_jawab') }}</span>
                                            <small class="text-muted">{{ session('username') }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>

                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="showLogoutAlert();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout-kec') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!--/ User -->
                </ul>
            </div>
        </nav>

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


        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Data Kec {{ session('username') }}
        </h4>

        <!-- DataTales Example -->
        <div class="card">
            <div class="table-responsive">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-secondary create-new btn-primary " tabindex="0" type="button"
                            data-bs-toggle="modal" data-bs-target="#modalCenter"><span><i
                                    class="bx bx-plus me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Add
                                    NewRecord</span></span>
                        </button>
                        <div class="btn-group ms-2">
                            <button class="btn btn-secondary dropdown-toggle btn-primary" tabindex="0" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span><i class="bx bx-export me-sm-1"></i> <span
                                        class="d-none d-sm-inline-block">Export</span></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-start">
                                <a id="exportPrint" class="dropdown-item" href="#">Print<span><i
                                            class="bx bx-printer me-1"></i></span></a>
                                <a id="exportCsv" class="dropdown-item" href="#">Csv<span><i
                                            class="bx bx-file me-1"></i></span></a>
                                <a id="exportPdf" class="dropdown-item" href="#">Pdf<span><i
                                            class="bx bxs-file-pdf me-1"></i></span></a>
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
                            @foreach ($permintaan as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y ') }}
                                    </td>

                                    <td>
                                        {{-- <a href="{{ asset('storage/' . $item->data_permintaan) }}" target="_blank">
                                            <span><i class="bx bx-file me-1"></i> Buka File</span>
                                        </a> --}}
                                        <a href="{{ route('view-pdf', ['filename' => basename($item->data_permintaan)]) }}"
                                            target="_blank">
                                            <span><i class="bx bx-file me-1"></i> Buka File</span>
                                        </a>

                                        {{-- <a href="{{ asset('storage/' . $item->data_permintaan) }}" target="_blank">
                                            <span><i class="bx bx-file me-1"></i> Unduh File PDF</span>
                                        </a> --}}



                                    </td>


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

            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Tambah Data Kebutuhan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/permintaan-form') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="text" name="id_kecamatan" value="{{ session('id_kecamatan') }}"
                                        hidden>
                                    <input type="text" name="id_user_kec" value="{{ session('id') }}" hidden>
                                    <div class="mb-3">
                                        <label for="data_permintaan" class="form-label">Unggah File</label>
                                        <div class="input-group">
                                            <input type="file" id="data_permintaan"
                                                class="form-control @error('data_permintaan') is-invalid @enderror"
                                                name="data_permintaan" value="{{ old('data_permintaan') }}"
                                                required />
                                            <span class="input-group-text">.pdf</span>
                                            @error('data_permintaan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="kebutuhan" class="form-label">Kebutuhan Beras (Kg)</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" id="kebutuhan" pattern="[0-9]+"
                                                class="form-control @error('jumlah_permintaan_beras') is-invalid @enderror"
                                                name="jumlah_permintaan_beras"
                                                value="{{ old('jumlah_permintaan_beras') }}" required>
                                            <span class="input-group-text">Kg</span>
                                            @error('jumlah_permintaan_beras')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="col mb-0">
                                        <label for="penerima" class="form-label">Jumlah Penerima (Rts)</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" id="penerima" pattern="[0-9]+"
                                                class="form-control @error('jumlah_rts') is-invalid @enderror"
                                                name="jumlah_rts" value="{{ old('jumlah_rts') }}" required>
                                            <span class="input-group-text">RTS</span>
                                            @error('jumlah_rts')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- Perbaikan: Pindahkan button submit ke dalam modal-footer -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <!-- Perbaikan: Tambahkan button untuk menutup modal jika diperlukan -->
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>




        </div>
    </div>
    <!-- / Layout wrapper -->
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->


    <!-- databless  -->



    <!-- Sertakan JavaScript DataTables dan Buttons -->

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.print.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/assets/js/datatables-demo.js"></script>

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#modalCenter').modal('show');
            });
        </script>
    @endif


    <script>
        function showLogoutAlert() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari sesi ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>


</body>

</html>
