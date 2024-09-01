@extends('layout.main', [
    'namePage' => 'Data-Gudang',
])
@section('title', 'BULOG | Data Gudang')
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
            <span class="text-muted fw-light">Data /</span> Data Gudang
        </h4>

        <!-- DataTales Example -->
        <div class="card">

            <div class="table-responsive">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-secondary create-new btn-primary " tabindex="0" type="button"
                            data-bs-toggle="modal" data-bs-target="#modalCenter"><span><i class="bx bx-plus me-sm-1"></i>
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
                                <th>Kode Gudang</th>
                                <th>Nama Gudang</th>
                                <th>Lokasi</th>
                                <th>Kapasitas (Kg)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($gudang as $gdng)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $gdng->nama_gudang }}</td>
                                    <td>{{ $gdng->lokasi }}</td>
                                    <td>{{ number_format($gdng->kapasitas, 0, ',', '.') }} Kg</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit{{ $gdng->id }}">
                                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                                </a>
                                                <a class="dropdown-item delete-gudang" href="#"
                                                    data-gudang-id="{{ $gdng->id }}">
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
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Tambah Data Gudang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/gudang-form') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nama" class="form-label">Nama Gudang</label>
                                        <input type="text" id="nama"
                                            class="form-control  @error('nama_gudang') is-invalid @enderror"
                                            pattern="^[^0-9]+$" name="nama_gudang" placeholder="Nama Gudang"
                                            value="{{ old('nama_gudang') }}" required />
                                        @error('nama_gudang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="kebutuhan" class="form-label">Lokasi Gudang</label>
                                        <input type="text" id="kebutuhan"
                                            class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                                            pattern="^[^0-9]+$" placeholder="Lokasi Gudang" value="{{ old('lokasi') }}"
                                            required />
                                        @error('lokasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-0">
                                        <label for="penerima" class="form-label">Persediaan Beras (Kg)</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" id="penerima" pattern="[0-9]+"
                                                class="form-control  @error('kapasitas') is-invalid @enderror"
                                                name="kapasitas" value="{{ old('kapasitas') }}" required>
                                            <span class="input-group-text">Kg</span>
                                            @error('kapasitas')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        {{-- <input type="text" id="penerima" pattern="[0-9]+" class="form-control"
                                            name="kapasitas" placeholder="Jumlah Persediaan Beras" required /> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- Perbaikan: Pindahkan button submit ke dalam modal-footer -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <!-- Perbaikan: Tambahkan button untuk menutup modal jika diperlukan -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            @foreach ($gudang as $gudang)
                <!-- Modal edit untuk setiap item -->
                <div class="modal fade" id="modalEdit{{ $gudang->id }}" tabindex="-1"
                    aria-labelledby="modalEdit{{ $gudang->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditTitle">Edit Data gudang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editForm{{ $gudang->id }}" method="POST"
                                action="{{ url('/data-gudang/edit/' . $gudang->id) }}">
                                @csrf

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nama-gudang" class="form-label">Nama Gudang</label>
                                            <input type="text" id="nama"
                                                class="form-control  @error('nama_gudang_edit') is-invalid @enderror"
                                                name="nama_gudang_edit" placeholder="Nama Gudang"
                                                value="{{ old('nama_gudang_edit', $gudang->nama_gudang) }}" required />
                                            @error('nama_gudang_edit')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="lokasi" class="form-label">Lokasi Gudang</label>
                                            <input type="text" id="lokasi-gudang"
                                                class="form-control  @error('lokasi_edit') is-invalid @enderror"
                                                name="lokasi_edit" placeholder="Lokasi Gudang"
                                                value="{{ old('lokasi_edit', $gudang->lokasi) }}" required />
                                            @error('lokasi_edit')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col mb-0">
                                            <label for="persediaan" class="form-label">Persediaan Beras (Kg)</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" id="penerima" pattern="[0-9]+"
                                                    class="form-control  @error('kapasitas_edit') is-invalid @enderror"
                                                    name="kapasitas_edit"
                                                    value="{{ old('kapasitas_edit', $gudang->kapasitas) }}" required>
                                                <span class="input-group-text">Kg</span>
                                                @error('kapasitas_edit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            var modal = $('#modalCenter');
            var modalErrors = modal.find('.invalid-feedback');

            if (modalErrors.length > 0) {
                modal.modal('show');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var modal = $('#modalEdit{{ $gudang->id }}');
            var modalErrors = modal.find('.invalid-feedback');

            if (modalErrors.length > 0) {
                modal.modal('show');
            }
        });
    </script>


    <script>
        // Tambahkan event listener untuk tombol hapus
        document.addEventListener('click', function(event) {
            // Periksa apakah elemen yang diklik adalah tombol hapus dengan class 'delete-kecamatan'
            if (event.target.classList.contains('delete-gudang')) {
                event.preventDefault();

                // Ambil ID gudang dari atribut data
                var gudangId = event.target.getAttribute('data-gudang-id');

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
                        // Redirect ke URL penghapusan dengan ID gudang
                        window.location.href = '/data-gudang/delete/' + gudangId;
                    }
                });
            }
        });
    </script>





@endsection
