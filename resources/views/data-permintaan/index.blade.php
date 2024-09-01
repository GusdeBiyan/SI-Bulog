@extends('layout.main', [
'namePage' => 'Data-Kecamatan',
])
@section('title', 'BULOG | Data Permintaan')
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


    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Data /</span> Data Permintaan
    </h4>

    <!-- DataTales Example -->
    <div class="card">
        <div class="table-responsive">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    {{-- <button class="btn btn-secondary create-new btn-primary " tabindex="0" type="button"
                            data-bs-toggle="modal" data-bs-target="#modalCenter"><span><i class="bx bx-plus me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Add
                                    NewRecord</span></span>
                        </button> --}}
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
                            <th>Nama Kecamatan</th>
                            <th>Data Permintaan</th>
                            <th>Kebutuhan Beras /Kg</th>
                            <th>Jumlah Penerima (RTS)</th>
                            <th>Penanggung Jawab</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($permintaan as $item)
                        <tr>
                            <td scope="row">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y ') }}</td>
                            <td>{{ $item->kecamatan->nama_kecamatan }}</td>
                            <td>
                                <a href="{{ route('view-pdf', ['filename' => basename($item->data_permintaan)]) }}" target="_blank">
                                    <span><i class="bx bx-file me-1"></i> Buka File</span>
                                </a>
                            </td>
                            <td>{{ number_format($item->jumlah_permintaan_beras, 0, ',', '.') }} Kg</td>
                            <td>{{ number_format($item->jumlah_rts, 0, ',', '.') }} RTS</td>
                            <td>{{ $item->userkec->nama_penanggung_jawab }}</td>

                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item delete-permintaan" href="#" data-permintaan-id="{{ $item->id }}">
                                            <i class="bx bx-trash me-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->



    </div>
</div>


<script>
    // Tambahkan event listener untuk tombol hapus
    document.addEventListener('click', function(event) {
        // Periksa apakah elemen yang diklik adalah tombol hapus dengan class 'delete-kecamatan'
        if (event.target.classList.contains('delete-permintaan')) {
            event.preventDefault();

            // Ambil ID permintaan dari atribut data
            var permintaanId = event.target.getAttribute('data-permintaan-id');

            // Tampilkan SweetAlert untuk konfirmasi penghapusan
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                // Jika pengguna mengonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Redirect ke URL penghapusan dengan ID permintaan
                    window.location.href = '/permintaan-kec/delete/' + permintaanId;
                }
            });
        }
    });
</script>




@endsection