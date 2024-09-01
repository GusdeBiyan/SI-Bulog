@extends('layout.main', [
    'namePage' => 'Data-Distribusi',
])
@section('title', 'BULOG | Data Distribusi')
@section('content')

    <style>
        tbody {
            font-size: 13px
        }
    </style>

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
            <span class="text-muted fw-light">Data /</span> Data Distribusi
        </h4>

        <!-- DataTales Example -->
        <div class="card">
            <div class="table-responsive">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <!-- <button class="btn btn-secondary create-new btn-primary " tabindex="0" type="button"><span><i
                                                                                                                class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add
                                                                                                                NewRecord</span></span>
                                                                                                    </button> -->
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
                                <th>Asal </th>
                                <th>Tujuan</th>
                                <th>Jumlah Beras</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $totalBiaya = 0;
                            @endphp
                            @foreach ($distribusi as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y ') }}</td>
                                    <td>{{ $item->nama_gudang }}</td>
                                    <td>{{ $item->nama_kecamatan }}</td>
                                    <td>{{ $item->jumlah_beras }} Kg</td>
                                    <td>Rp {{ $item->biaya }}</td>
                                    {{-- <td>{{ number_format($item->jumlah_beras, 0, ',', '.') }} Kg</td> --}}
                                    {{-- <td>Rp. {{ number_format($item->biaya, 0, ',', '.') }}</td> --}}
                                    <td class="status"
                                        style="color: {{ $item->status == 'Belum' ? 'red' : 'green' }}; border-radius: 20px; ">
                                        {{ $item->status }}
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit{{ $item->id }}">
                                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                                </a>
                                                <a class="dropdown-item delete-distribusi" href="#"
                                                    data-distribusi-id="{{ $item->id }}">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{-- @php
                                    $totalBiaya += $item->biaya;
                                @endphp --}}
                            @endforeach

                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total Biaya</td>
                                <td>Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                    <td></td>
                    <td></td>
                    </tr>
                    </tfoot> --}}
                    </table>
                </div>
            </div>

            @foreach ($distribusi as $distribusi)
                <!-- Modal edit untuk setiap distribusi -->
                <div class="modal fade" id="modalEdit{{ $distribusi->id }}" tabindex="-1"
                    aria-labelledby="modalEdit{{ $distribusi->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditTitle">Edit Data distribusi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editForm{{ $distribusi->id }}" method="POST"
                                action="{{ url('/data-distribusi/edit/' . $distribusi->id) }}">
                                @csrf

                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <div class="col-md-10">
                                            <label for="html5-date-input" class="form-label">Tanggal
                                                Pelaksanaan</label>
                                            <input class="form-control" type="date" name="created_at"
                                                value="{{ $distribusi->created_at->format('Y-m-d') }}"
                                                id="html5-date-input" onkeydown="return false;">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="nama-gudang" class="form-label">Asal</label>
                                            <input type="text" id="nama-gudang" class="form-control" name="nama_gudang"
                                                value="{{ $distribusi->nama_gudang }}" required readonly />
                                        </div>
                                        <div class="col">
                                            <label for="lokasi" class="form-label">Tujuan</label>
                                            <input type="text" id="lokasi-distribusi" class="form-control"
                                                name="nama_kecamatan" value="{{ $distribusi->nama_kecamatan }}" required
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col mb-0">
                                            <label for="persediaan" class="form-label">Jumlah beras (Kg)</label>
                                            <div class="input-group input-group-merge">

                                                <input type="text" id="lokasi-distribusi" class="form-control"
                                                    name="jumlah_beras" value="{{ $distribusi->jumlah_beras }}" required
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col mb-0">
                                            <label for="persediaan" class="form-label">Biaya</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" id="lokasi-distribusi" class="form-control"
                                                    name="biaya" value="{{ $distribusi->biaya }}" required readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="nama-kecamatan" class="form-label">Status</label>
                                            <select style="width: auto" class="form-select" name="status"
                                                id="kecamatan" required>
                                                <option value="">Pilih Status</option>
                                                <option value="Selesai"
                                                    {{ $distribusi->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                                </option>
                                                <option value="Belum"
                                                    {{ $distribusi->status == 'Belum' ? 'selected' : '' }}>Belum</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Tambahkan event listener untuk tombol hapus
        document.addEventListener('click', function(event) {
            // Periksa apakah elemen yang diklik adalah tombol hapus dengan class 'delete-kecamatan'
            if (event.target.classList.contains('delete-distribusi')) {
                event.preventDefault();

                // Ambil ID distribusi dari atribut data
                var distribusiId = event.target.getAttribute('data-distribusi-id');

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
                        // Redirect ke URL penghapusan dengan ID distribusi
                        window.location.href = '/data-distribusi/delete/' + distribusiId;
                    }
                });
            }
        });
    </script>


@endsection
