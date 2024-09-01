@extends('layout.main', [
    'namePage' => 'Data-Biaya',
])
@section('title', 'BULOG | Data Biaya Pengiriman')
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
            <span class="text-muted fw-light">Data /</span> Data Biaya Pengiriman
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
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Jarak /Km</th>
                                <th>Biaya Pengiriman /Kg</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($biaya as $item)
                                <tr>
                                    <td>{{ $item->gudang->nama_gudang }}</td>
                                    <td>{{ $item->kecamatan->nama_kecamatan }}</td>
                                    <td>{{ $item->jarak }} Km</td>
                                    <td> Rp.{{ $item->biaya_pengiriman }}</td>
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
                                                <a class="dropdown-item delete-biaya" href="#"
                                                    data-biaya-id="{{ $item->id }}">
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

            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Tambah Data Biaya</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/biaya-form') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <label for="nama-gudang" class="form-label">Asal</label>
                                        <select style="width: auto" class="form-select" name="id_gudang" id="gudang"
                                            required>
                                            <option value="">Asal</option>
                                            @foreach ($data_gudang as $item)
                                                <option data-gudang="{{ $item->nama_gudang }}" value="{{ $item->id }}">
                                                    {{ $item->nama_gudang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="nama-kecamatan" class="form-label">Tujuan</label>
                                        <select style="width: auto" class="form-select" name="id_kecamatan" id="kecamatan"
                                            required>
                                            <option value="">Tujuan</option>
                                            @foreach ($data_kecamatan as $item)
                                                <option data-kecamatan="{{ $item->nama_kecamatan }}"
                                                    value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="penerima" class="form-label">Jarak (Km)</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" class="form-control @error('jarak') is-invalid @enderror"
                                                placeholder="Masukan Jarak" aria-label="Amount (to the nearest dollar)"
                                                name="jarak" required>
                                            <span class="input-group-text">Km</span>
                                            @error('jarak')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="penerima" class="form-label">Biaya Pengiriman Per
                                            Kg</label>
                                        <div class="input-group input-group-merge">
                                            {{-- <span class="input-group-text">Rp</span> --}}
                                            <input type="number"
                                                class="form-control @error('biaya_pengiriman') is-invalid @enderror"
                                                placeholder="100" aria-label="Amount (to the nearest dollar)"
                                                name="biaya_pengiriman" required>
                                            <span class="input-group-text">.00</span>
                                            @error('biaya_pengiriman')
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            @foreach ($biaya as $biaya)
                <!-- Modal edit untuk setiap item -->
                <div class="modal fade" id="modalEdit{{ $biaya->id }}" tabindex="-1"
                    aria-labelledby="modalEdit{{ $biaya->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditTitle">Edit Data Kecamatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editForm{{ $biaya->id }}" method="POST"
                                action="{{ url('/data-biaya/edit/' . $biaya->id) }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <label for="nama-gudang" class="form-label">Asal</label>
                                            <select style="width: auto" class="form-select" name="id_gudang_edit"
                                                id="gudang" required>
                                                <option value="{{ $biaya->id_gudang }}">{{ $biaya->gudang->nama_gudang }}
                                                </option>
                                                @foreach ($data_gudang as $item)
                                                    <option data-gudang="{{ $item->nama_gudang }}"
                                                        value="{{ $item->id }}">
                                                        {{ $item->nama_gudang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="nama-kecamatan" class="form-label">Tujuan</label>
                                            <select style="width: auto" class="form-select" name="id_kecamatan_edit"
                                                id="kecamatan" required>
                                                <option value="{{ $biaya->id_kecamatan }}">
                                                    {{ $biaya->kecamatan->nama_kecamatan }}
                                                </option>
                                                @foreach ($data_kecamatan as $item)
                                                    <option data-kecamatan="{{ $item->nama_kecamatan }}"
                                                        value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="penerima" class="form-label">Jarak (Km)</label>
                                            <div class="input-group input-group-merge">
                                                <input type="number"
                                                    class="form-control @error('jarak_edit') is-invalid @enderror"
                                                    aria-label="Amount (to the nearest dollar)"
                                                    value="{{ old('jarak_edit', $biaya->jarak) }}" name="jarak_edit"
                                                    required>
                                                <span class="input-group-text">Km</span>
                                                @error('jarak_edit')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="penerima" class="form-label">Biaya Pengiriman Per
                                                Kg</label>
                                            <div class="input-group input-group-merge">

                                                <input type="number"
                                                    class="form-control @error('biaya_pengiriman_edit') is-invalid @enderror"
                                                    placeholder="100" aria-label="Amount (to the nearest dollar)"
                                                    value="{{ old('biaya_pengiriman_edit', $biaya->biaya_pengiriman) }}"
                                                    name="biaya_pengiriman_edit" required>
                                                <span class="input-group-text">.00</span>
                                                @error('biaya_pengiriman_edit')
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
            var modal = $('#modalEdit{{ $biaya->id }}');
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
            if (event.target.classList.contains('delete-biaya')) {
                event.preventDefault();

                // Ambil ID biaya dari atribut data
                var biayaId = event.target.getAttribute('data-biaya-id');

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
                        // Redirect ke URL penghapusan dengan ID biaya
                        window.location.href = '/data-biaya/delete/' + biayaId;
                    }
                });
            }
        });
    </script>





@endsection
