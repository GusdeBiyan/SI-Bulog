@extends('layout.main', [
    'namePage' => 'Dashboard',
])
@section('title', 'BULOG | Dashboard')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

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


        <div class="row">
            <div class="col-md-12 col-lg-4 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                    </div>
                    <div class="card-body px-0">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex p-4 pt-3">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="/assets/img/icons/unicons/wallet.png" alt="User" />
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Biaya Distribusi</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ number_format($totalBiaya, 0, ',', '.') }}
                                            </h6>
                                            {{-- <small class="text-success fw-medium">
                                                        <i class="bx bx-chevron-up"></i>
                                                        42.9%
                                                    </small> --}}
                                        </div>
                                    </div>
                                </div>
                                <div id="incomeChart"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col">
                            <h5 class="card-header m-0 me-2 pb-3">Permintaan Beras Kecamatan</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            <div class="col-12 col-md-8 col-lg-8 order-3 order-md-2">
                <div class="row">


                    <div class="col-8 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="/assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                            <a class="dropdown-item" href="/data-distribusi">View More</a>
                                            {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-medium d-block mb-1">Jumlah Distribusi Selesai</span>
                                <h3 class="card-title mb-2">{{ $distribusi_selesai }}</h3>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
