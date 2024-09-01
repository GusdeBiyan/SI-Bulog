@extends('layout.main', [
    'namePage' => 'optimasi-biaya-transportasi',
])
@section('title', 'BULOG | Optimasi Biaya Transaportasi')
@section('content')

    <style>
        .form-perhitungan {
            font-size: 12px;
        }

        .output {
            font-size: 15px;
        }

        .form-select {
            font-size: 12px
        }

        option:disabled {
            background-color: #f0f0f0;
            /* Ubah warna latar belakang menjadi abu-abu */
            color: #999;

            /* Ubah warna teks menjadi abu-abu */
        }

        .btn.btn-primary:disabled {
            cursor: not-allowed;
            opacity: 0.5;
            /* Optionally reduce opacity for visual indication */
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Data /</span> Perhitungan Optimasi biaya
        </h4>

        <!-- DataTales Example -->
        <div class="form-perhitungan">
            <div class="card">
                <div class="table-responsive">
                    <div class="card-body">
                        <button class="btn btn-secondary create-new btn-primary" onclick="location.reload()"><i
                                class="bx bx-refresh me-sm-1"></i></button>
                        <table class="table" style="min-width: 800px">
                            <thead>
                                <tr>
                                    <th></th>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <th>
                                            <select style="width: auto" class="form-select" name="kecamatan"
                                                id="kecamatan{{ $i }}">
                                                <option value="">Tujuan</option>
                                                @foreach ($kecamatan as $item)
                                                    <option data-kecamatan="{{ $item->nama_kecamatan }}"
                                                        value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        </th>
                                    @endfor
                                    <th>Persediaan (per Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <td>
                                            <select style="width: auto" class="form-select" name="gudang"
                                                id="gudang{{ $i }}">
                                                <option value="">Asal</option>
                                                @foreach ($gudang as $item)
                                                    <option data-gudang="{{ $item->nama_gudang }}"
                                                        value="{{ $item->id }}">
                                                        {{ $item->nama_gudang }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @for ($j = 1; $j <= 5; $j++)
                                            <td>
                                                <div id="biaya{{ ($i - 1) * 5 + $j }}"></div>
                                            </td>
                                        @endfor
                                        <td>
                                            <div id="kapasitas{{ $i }}"></div>
                                        </td>
                                    </tr>
                                @endfor
                                <tr>
                                    <td>Permintaan (Per Kg)</td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <td>
                                            <div id="kebutuhan{{ $i }}"></div>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4">
                            <button id="btnHitungOptimasi" class="btn btn-primary">Hitung Optimasi Biaya</button>
                        </div>




                    </div>
                </div>
                {{-- <form id="routeForm">
                    <!-- Tempat untuk menampilkan input -->
                </form> --}}
            </div>
            <div class="card mt-4 p-3">

                <h4>Hasil Perhitungan :</h4>

                <form action="{{ '/distribusi-form' }}" method="POST">
                    @csrf

                    <div class="output p-3" id="output"></div>
                    <div id="tableContainer"></div>
                </form>
            </div>


        </div>

    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var btnHitungOptimasi = document.getElementById("btnHitungOptimasi");
            var kecamatanInputs = [];
            var gudangInputs = [];


            // Inisialisasi input kecamatan dan gudang
            for (var i = 1; i <= 5; i++) {
                kecamatanInputs.push(document.getElementById("kecamatan" + i));
                gudangInputs.push(document.getElementById("gudang" + i));
            }

            // Fungsi untuk memeriksa apakah nilai null
            function isNull(value) {
                return value === null || value === undefined || value === '';
            }

            // Fungsi untuk memeriksa jumlah input yang terisi
            function checkValues() {
                var kecamatanCount = 0;
                var gudangCount = 0;

                // Periksa input kecamatan
                for (var i = 0; i < 5; i++) {
                    if (!isNull(kecamatanInputs[i].value)) {
                        kecamatanCount++;
                    }
                }

                // Periksa input gudang
                for (var i = 0; i < 5; i++) {
                    if (!isNull(gudangInputs[i].value)) {
                        gudangCount++;
                    }
                }

                // Jika minimal 2 kecamatan dan 2 gudang terisi, aktifkan tombol
                if (kecamatanCount >= 2 && gudangCount >= 2) {
                    btnHitungOptimasi.disabled = false;
                } else {
                    btnHitungOptimasi.disabled = true;
                }


            }

            // Panggil fungsi checkValues saat halaman dimuat
            checkValues();

            // Tambahkan event listener untuk setiap input kecamatan
            for (var i = 0; i < 5; i++) {
                kecamatanInputs[i].addEventListener("input", checkValues);
            }

            // Tambahkan event listener untuk setiap input gudang
            for (var i = 0; i < 5; i++) {
                gudangInputs[i].addEventListener("input", checkValues);
            }
        });
    </script>



    <script>
        // Data array dari PHP
        var biaya = {!! json_encode($biaya) !!};
        var kecamatan = {!! json_encode($kecamatan) !!};
        var gudang = {!! json_encode($gudang) !!};

        // Fungsi untuk mencari data biaya berdasarkan ID gudang dan ID kecamatan
        function cariBiaya(idGudang, idKecamatan) {
            var hasilCocok = [];
            for (var i = 0; i < biaya.length; i++) {
                if (biaya[i].id_gudang == idGudang && biaya[i].id_kecamatan == idKecamatan) {
                    hasilCocok.push(biaya[i]);
                }
            }
            return hasilCocok; // Mengembalikan array hasil pencarian
        }

        // fungsi untuk mencari kapasitas tiap gudang
        function cariKapasitas(idGudang) {
            // Loop melalui array gudang untuk mencari gudang dengan ID yang sesuai
            for (var i = 0; i < gudang.length; i++) {
                if (gudang[i].id == idGudang) {
                    return gudang[i].kapasitas; // Mengembalikan kapasitas gudang yang sesuai
                }
            }
            return ''; // Mengembalikan string kosong jika tidak ditemukan
        }

        // fungsi untuk mencari kebutuhan tiap Kecamatan
        function cariKebutuhan(idKecamatan) {
            // Loop melalui array gudang untuk mencari gudang dengan ID yang sesuai
            for (var i = 0; i < kecamatan.length; i++) {
                if (kecamatan[i].id == idKecamatan) {
                    return kecamatan[i].kebutuhan_beras; // Mengembalikan kapasitas gudang yang sesuai
                }
            }
            return ''; // Mengembalikan string kosong jika tidak ditemukan
        }

        // Fungsi untuk menampilkan data biaya ke dalam div yang sesuai
        function tampilkanBiaya(gudangId, kecamatanId, divId) {

            var dataBiaya = cariBiaya(gudangId, kecamatanId);
            var divBiaya = document.getElementById(divId);
            var btnHitungOptimasi = document.getElementById("btnHitungOptimasi");

            // Hapus isi div biaya sebelum menambahkan hasil pencarian biaya baru
            divBiaya.innerHTML = '';

            // Menampilkan hasil pencarian biaya dalam div yang sesuai
            if (dataBiaya.length === 0) {
                // Jika tidak ada biaya yang ditemukan, tampilkan pesan "Biaya tidak ditemukan"
                var alertBiayaNotFound = document.createElement('div');
                alertBiayaNotFound.classList.add('alert', 'alert-danger');
                alertBiayaNotFound.textContent = 'Biaya tidak ditemukan';
                divBiaya.appendChild(alertBiayaNotFound);
                btnHitungOptimasi.disabled = true;
            } else {
                for (var k = 0; k < dataBiaya.length; k++) {
                    var biaya = dataBiaya[k];
                    var idBiaya = divId + '_' + k; // Buat id unik untuk setiap hasil pencarian biaya
                    var divBiayaDetail = document.createElement('div');
                    divBiayaDetail.id = idBiaya;
                    divBiayaDetail.textContent = biaya.biaya_pengiriman;
                    divBiaya.appendChild(divBiayaDetail);
                }
            }


        }

        // Menambahkan event listener untuk setiap gudang dan kecamatan
        for (var i = 1; i <= 5; i++) {
            for (var j = 1; j <= 5; j++) {
                var selectGudang = document.getElementById('gudang' + i);
                var selectKecamatan = document.getElementById('kecamatan' + j);
                var divBiaya = document.getElementById('biaya' + ((i - 1) * 5 + j));

                selectGudang.addEventListener('change', createChangeListener(selectGudang, selectKecamatan, divBiaya));
                selectKecamatan.addEventListener('change', createChangeListener(selectGudang, selectKecamatan, divBiaya));
            }
        }

        // Fungsi untuk membuat event listener
        function createChangeListener(gudangElement, kecamatanElement, biayaElement) {
            return function() {
                var gudangId = parseInt(gudangElement.value);
                var kecamatanId = parseInt(kecamatanElement.value);

                if (isNaN(gudangId) || isNaN(kecamatanId) || gudangId === 0 || kecamatanId === 0) {
                    // Jika salah satu atau kedua opsi belum dipilih, beri pesan kepada pengguna

                    return;
                } else {
                    tampilkanBiaya(gudangId, kecamatanId, biayaElement.id);
                }



            };
        }

        // Objek untuk menyimpan opsi yang dipilih di setiap elemen select gudang
        var selectedOptions = {};

        // Menangani perubahan pada setiap elemen select gudang
        var selectedValues = {}; // Objek untuk menyimpan nilai opsi yang dipilih di setiap elemen select gudang

        // Menangani perubahan pada setiap elemen select gudang
        for (var i = 1; i <= 5; i++) {
            var selectGudang = document.getElementById('gudang' + i);
            selectGudang.addEventListener('change', function(event) {
                var previousSelectedValue = selectedValues[event.target
                    .id]; // Nilai opsi yang dipilih sebelum perubahan
                var selectedValue = event.target.value; // Nilai opsi yang dipilih setelah perubahan

                var kapasitasDiv = document.getElementById('kapasitas' + event.target.id.slice(-
                    1)); // Mengambil angka terakhir dari ID gudang

                if (selectedValue) {
                    var kapasitas = cariKapasitas(selectedValue);
                    kapasitasDiv.textContent = kapasitas;
                } else {
                    kapasitasDiv.textContent = ''; // Kosongkan jika tidak ada gudang yang dipilih
                }


                // Menonaktifkan opsi yang dipilih di semua elemen select gudang, kecuali elemen yang sedang berubah
                for (var j = 1; j <= 5; j++) {
                    if ('gudang' + j !== event.target.id) {
                        var otherSelectGudang = document.getElementById('gudang' + j);
                        var options = otherSelectGudang.getElementsByTagName('option');
                        for (var k = 0; k < options.length; k++) {
                            var option = options[k];
                            if (option.value === selectedValue && selectedValue !== '') {
                                option.disabled = true;
                            } else if (option.value === previousSelectedValue && previousSelectedValue !== '') {
                                option.disabled = false;
                            }
                        }
                    }
                }

                // Menyimpan nilai opsi yang dipilih setelah perubahan
                selectedValues[event.target.id] = selectedValue;
            });
        }

        // Menangani perubahan pada setiap elemen select kecamatan
        for (var i = 1; i <= 5; i++) {
            var selectKecamatan = document.getElementById('kecamatan' + i);
            selectKecamatan.addEventListener('change', function(event) {
                var previousSelectedValue = selectedValues[event.target
                    .id]; // Nilai opsi yang dipilih sebelum perubahan
                var selectedValue = event.target.value; // Nilai opsi yang dipilih setelah perubahan


                var kebutuhanDiv = document.getElementById('kebutuhan' + event.target.id.slice(-
                    1)); // Mengambil angka terakhir dari ID gudang

                if (selectedValue) {
                    var kebutuhan = cariKebutuhan(selectedValue);
                    kebutuhanDiv.textContent = kebutuhan;
                } else {
                    kebutuhanDiv.textContent = ''; // Kosongkan jika tidak ada gudang yang dipilih
                }

                // Menonaktifkan opsi yang dipilih di semua elemen select kecamatan, kecuali elemen yang sedang berubah
                for (var j = 1; j <= 5; j++) {
                    if ('kecamatan' + j !== event.target.id) {
                        var otherSelectKecamatan = document.getElementById('kecamatan' + j);
                        var options = otherSelectKecamatan.getElementsByTagName('option');
                        for (var k = 0; k < options.length; k++) {
                            var option = options[k];
                            if (option.value === selectedValue && selectedValue !== '') {
                                option.disabled = true;
                            } else if (option.value === previousSelectedValue && previousSelectedValue !== '') {
                                option.disabled = false;
                            }
                        }
                    }
                }

                // Menyimpan nilai opsi yang dipilih setelah perubahan
                selectedValues[event.target.id] = selectedValue;
            });
        }
    </script>

    <script>
        // // Variabel untuk menyimpan data yang dipilih dari setiap elemen select
        // var selectedData = {
        //     gudang: [],
        //     kecamatan: []

        // };

        // // Menangani perubahan pada setiap elemen select gudang
        // for (var i = 1; i <= 5; i++) {
        //     var selectGudang = document.getElementById('gudang' + i);
        //     selectGudang.addEventListener('change', function(event) {
        //         var selectedValue = event.target.value; // Mendapatkan nilai opsi yang dipilih
        //         selectedData.gudang[event.target.id] =
        //             selectedValue; // Menyimpan nilai opsi yang dipilih ke dalam variabel selectedData
        //     });
        // }

        // // Menangani perubahan pada setiap elemen select kecamatan
        // for (var i = 1; i <= 5; i++) {
        //     var selectKecamatan = document.getElementById('kecamatan' + i);
        //     selectKecamatan.addEventListener('change', function(event) {
        //         var selectedValue = event.target.value; // Mendapatkan nilai opsi yang dipilih
        //         selectedData.kecamatan[event.target.id] =
        //             selectedValue; // Menyimpan nilai opsi yang dipilih ke dalam variabel selectedData
        //     });
        // }

        // Menangani klik pada tombol untuk menyimpan data dan menghitung biaya
        var buttonHitungOptimasi = document.getElementById('btnHitungOptimasi');
        buttonHitungOptimasi.addEventListener('click', function() {

            // Inisialisasi matriks 5x5 untuk menyimpan biaya pengiriman
            var matrix = [];
            var origin = [];
            var destination = [];
            var need = [];
            var availability = [];


            //menyimpan data gudang
            for (var i = 1; i <= 5; i++) {
                // Mendapatkan elemen dropdown berdasarkan ID
                var selectGudang = document.getElementById('gudang' + i);

                // Mendapatkan nilai dari atribut data-nama-gudang
                var selectedValue = selectGudang.options[selectGudang.selectedIndex].getAttribute('data-gudang');

                // Menambahkan nilai ke dalam array origin
                origin.push(selectedValue);
            }

            //menyimpan data kecamtan
            for (var i = 1; i <= 5; i++) {
                var selectKecamatan = document.getElementById('kecamatan' + i);
                // var selectedValue = selectKecamatan.value; // Mendapatkan nilai opsi yang dipilih

                var selectedValue = selectKecamatan.options[selectKecamatan.selectedIndex].getAttribute(
                    'data-kecamatan');
                destination.push(selectedValue); // Menyimpan nilai opsi yang dipilih ke dalam matriks
            }

            // Menyimpan biaya pengiriman dari data yang diberikan
            for (var i = 1; i <= 5; i++) {
                // Inisialisasi baris matriks untuk gudang ke-i
                matrix[i - 1] = [];

                for (var j = 1; j <= 5; j++) {
                    var divBiaya = document.getElementById('biaya' + ((i - 1) * 5 + j));
                    var biayaValue = parseFloat(divBiaya.textContent.trim());

                    // Menyimpan nilai biaya ke dalam matriks
                    matrix[i - 1][j - 1] = isNaN(biayaValue) ? null : biayaValue;
                }
            }


            // Menyimpan kebutuhan dari setiap elemen div ke dalam matriks
            for (var i = 1; i <= 5; i++) {
                var divKebutuhan = document.getElementById('kebutuhan' + i);
                var kebutuhanValue = parseFloat(divKebutuhan.textContent.trim());

                // Menyimpan nilai kebutuhan ke dalam matriks
                need.push(isNaN(kebutuhanValue) ? null : kebutuhanValue);
            }


            // Menyimpan kebutuhan dari setiap elemen div ke dalam matriks
            for (var i = 1; i <= 5; i++) {
                var divKapasitas = document.getElementById('kapasitas' + i);
                var kapasitasValue = parseFloat(divKapasitas.textContent.trim());

                // Menyimpan nilai kebutuhan ke dalam matriks
                availability.push(isNaN(kapasitasValue) ? null : kapasitasValue);
            }


            let resultMatrix = [];

            function resetResultMatrix(matrix) {
                let resultMatrix = [];
                for (let i = 0; i < matrix.length; i++) {
                    let column = [];
                    for (let j = 0; j < matrix[0].length; j++) {
                        column.push(0);
                    }
                    resultMatrix.push([...column]);
                    column.length = 0;
                }
                return resultMatrix;
            }

            function sumWithoutNone(iterable) {
                let result = 0;
                for (let number of iterable) {
                    if (number !== null) {
                        result += number;
                    }
                }
                return result;
            }

            function insertArtificialOrigin(matrix, origin, destination, need, availability) {
                origin.push('dummy');
                let line = [];
                for (let i = 0; i < destination.length; i++) {
                    line.push(0);
                }
                matrix.push([...line]);
                availability.push(Math.max(0, need.reduce((acc, curr) => acc + curr, 0) - availability.reduce((acc,
                        curr) =>
                    acc + curr, 0)));
            }

            function insertArtificialDestination(matrix, destination, availability) {
                destination.push('dummy');
                for (let line of matrix) {
                    line.push(0);
                }
                need.push(Math.max(0, availability.reduce((acc, curr) => acc + curr, 0) - need.reduce((acc, curr) =>
                    acc + curr,
                    0)));
            }

            function calculatePenalties(matrix, need, availability) {
                let originPenalty = [];
                let destinationPenalty = [];
                let column = [];

                for (let line of matrix) {
                    originPenalty.push(differenceLowerCosts(iterableWithoutNone(line.slice(), need)));
                }

                for (let j = 0; j < matrix[0].length; j++) {
                    column = [];
                    for (let k = 0; k < matrix.length; k++) {
                        column.push(matrix[k][j]);
                    }
                    destinationPenalty.push(differenceLowerCosts(iterableWithoutNone(column.slice(),
                        availability)));
                }

                return [originPenalty, destinationPenalty];
            }

            function differenceLowerCosts(iterable) {
                let best = Math.min(...iterable);
                let indexBest = iterable.indexOf(best);
                iterable.splice(indexBest, 1);

                if (iterable.length === 0) {
                    return best;
                }

                let alternative = Math.min(...iterable);
                return Math.abs(alternative - best);
            }

            function getColumns(matrix, index) {
                let column = [];
                for (let i = 0; i < matrix.length; i++) {
                    column.push(matrix[i][index]);
                }
                return column;
            }

            function iterableWithoutNone(iterable, comparable) {
                let iterableWithoutNone = [];
                for (let i = 0; i < iterable.length; i++) {
                    if (comparable !== undefined) {
                        if (comparable[i] !== null) {
                            iterableWithoutNone.push(iterable[i]);
                        }
                    } else {
                        if (iterable[i] !== null) {
                            iterableWithoutNone.push(iterable[i]);
                        }
                    }
                }
                return iterableWithoutNone;
            }

            function findLowerCell(originPenalty, destinationPenalty, matrix, need, availability) {
                let result = [];
                let maxDifferenceOrigin = Math.max(...originPenalty);
                let maxDifferenceDestination = Math.max(...destinationPenalty);
                let indexMaxDifference;

                if (maxDifferenceOrigin < maxDifferenceDestination) {
                    indexMaxDifference = destinationPenalty.indexOf(maxDifferenceDestination);
                    let column = getColumns(matrix, indexMaxDifference);
                    let lowerCostValue = Math.min(...iterableWithoutNone(column.slice(), availability));
                    result.push(indexMaxDifference, lowerCostValue, column.indexOf(lowerCostValue));
                } else {
                    indexMaxDifference = originPenalty.indexOf(maxDifferenceOrigin);
                    let lowerCostValue = Math.min(...iterableWithoutNone(matrix[indexMaxDifference].slice(), need));
                    result.push(indexMaxDifference, lowerCostValue, matrix[indexMaxDifference].indexOf(
                        lowerCostValue));
                    result.reverse();
                }

                return result;
            }

            function calculateResult(resultMatrix) {
                let z = 0;
                for (let i = 0; i < resultMatrix.length; i++) {
                    for (let j = 0; j < resultMatrix[0].length; j++) {
                        z += resultMatrix[i][j];
                    }
                }
                return z;
            }


            function printMatrix(matrix, origin, destination) {
                // Calculate the maximum width for origin and destination labels
                let originWidth = 0;
                let destinationWidth = 0;

                // Determine the maximum width for origin labels using loops
                for (let i = 0; i < origin.length; i++) {
                    if (origin[i]) {
                        if (origin[i].length > originWidth) {
                            originWidth = origin[i].length;
                        }
                    }
                }
                originWidth += 1;

                // Determine the maximum width for destination labels using loops
                for (let j = 0; j < destination.length; j++) {
                    if (destination[j]) {
                        if (destination[j].length > destinationWidth) {
                            destinationWidth = destination[j].length;
                        }
                    }
                }
                destinationWidth += 1;

                // Create the header row
                let header = " ".repeat(originWidth);
                for (let dest of destination) {
                    header += ` | ${(dest || "").padEnd(destinationWidth)}`;
                }
                console.log(header);

                // Create the separator line
                let separator = "-".repeat(header.length);
                console.log(separator);

                // Create the matrix rows with origin labels and corresponding values
                for (let i = 0; i < origin.length; i++) {
                    let row = `${(origin[i] || "").padEnd(originWidth)} |`;
                    for (let j = 0; j < destination.length; j++) {
                        let cellValue = matrix[i][j];
                        if (cellValue !== null) {
                            row += ` ${(cellValue.toString().padEnd(destinationWidth))} |`;
                        } else {
                            row +=
                                ` ${(cellValue || "").toString().padEnd(destinationWidth)} |`; // Leave it empty for null values
                        }
                    }
                    console.log(row);
                    console.log(separator); // Add separator after each row
                }
            }





            // function printMatrix(matrix, origin, destination) {
            //     // Create table element
            //     let table = document.createElement('table');

            //     // Create table header row
            //     let headerRow = document.createElement('tr');
            //     let originHeaderCell = document.createElement('th');
            //     originHeaderCell.textContent = ' ';
            //     headerRow.appendChild(originHeaderCell);
            //     for (let dest of destination) {
            //         let destHeaderCell = document.createElement('th');
            //         destHeaderCell.textContent = dest;
            //         headerRow.appendChild(destHeaderCell);
            //     }
            //     table.appendChild(headerRow);

            //     // Create table rows with data
            //     for (let i = 0; i < matrix.length; i++) {
            //         let row = document.createElement('tr');
            //         let originCell = document.createElement('td');
            //         originCell.textContent = origin[i];
            //         row.appendChild(originCell);
            //         for (let j = 0; j < matrix[0].length; j++) {
            //             let dataCell = document.createElement('td');
            //             dataCell.textContent = matrix[i][j];
            //             row.appendChild(dataCell);
            //         }
            //         table.appendChild(row);
            //     }

            //     // Append table to a container element in the HTML document
            //     document.getElementById('tableContainer').appendChild(table);
            // }

            // function printRoute(origin, destination, resultMatrix, resultPrice) {
            //     for (let i = 0; i < origin.length; i++) {
            //         for (let j = 0; j < destination.length; j++) {
            //             if (resultMatrix[i][j] !== 0) {
            //                 let cost = resultPrice[i][j];
            //                 let quantity = resultMatrix[i][j].split('.')[1];
            //                 console.log(
            //                     `${origin[i]} => ${destination[j]} = ${quantity} Kg yang di distribusikan , Biaya =>${cost}`
            //                 );
            //             }
            //         }
            //     }
            // }

            // function printRouteToHTML(origin, destination, resultMatrix, resultPrice) {
            //     let outputHTML = '<p>Hasil Perhitungan:</p><ul>';

            //     let totalCost = 0; // Variabel untuk menyimpan total biaya

            //     for (let i = 0; i < origin.length; i++) {
            //         for (let j = 0; j < destination.length; j++) {
            //             if (resultMatrix[i][j] !== 0) {
            //                 let cost = resultPrice[i][j];
            //                 totalCost += cost; // Menambahkan biaya ke total biaya
            //                 let quantity = resultMatrix[i][j].split('.')[1];
            //                 outputHTML +=
            //                     `<li>${origin[i]} => ${destination[j]} = ${quantity} Kg yang di distribusikan , Biaya => Rp.${parseFloat(cost).toLocaleString('id-ID')}</li>`;
            //             }
            //         }
            //     }
            //     outputHTML += '</ul>';

            //     // Menambahkan total biaya ke dalam outputHTML
            //     outputHTML += `<p>Total Biaya Keseluruhan: Rp.${parseFloat(totalCost).toLocaleString('id-ID')}</p>`;


            //     // outputHTML +=
            //     //     `<button id="btnPlanDistribution" class="btn btn-primary">Rencanakan Distribusi</button>`;

            //     // Mengubah elemen HTML dengan id 'output' dengan outputHTML
            //     document.getElementById('output').innerHTML = outputHTML;
            // }

            function printRouteToHTML(origin, destination, resultMatrix, resultPrice) {
                let outputHTML = ''; // Inisialisasi outputHTML
                let index = 1; // Inisialisasi index

                for (let i = 0; i < origin.length; i++) {
                    for (let j = 0; j < destination.length; j++) {
                        if (resultMatrix[i][j] !== 0) {
                            let cost = resultPrice[i][j];
                            let quantity = resultMatrix[i][j].split('.')[1];


                            outputHTML +=
                                `  <div class="row mt-3">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="form-label">Asal</label>
                                                <input type="text" class="form-control" value="${origin[i]}" readonly
                                                    name="gudang${index}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="form-label">Tujuan</label>
                                                <input type="text" class="form-control" value="${destination[j]}"
                                                    readonly name="kecamatan${index}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Jumlah beras (Kg)</label>

                                             <div class="input-group input-group-merge">
                                                <input type="text" class="form-control" name="jumlah_beras${index}"
                                                    value="${parseFloat(quantity).toLocaleString('id-ID')}" required>
                                                <span class="input-group-text">Kg</span>
                                            </div>
                                        </div>
                                        <div class="col" hidden>
                                            <label class="form-label">status</label>
                                            <input type="text" class="form-control" value="Belum" readonly
                                                name="status${index}">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Biaya</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control" name="biaya${index}"
                                                    value="${parseFloat(cost).toLocaleString('id-ID')}" required readonly>
                                            </div>

                                        </div>

                                    </div>`;

                            index++; // Increment index
                        }
                    }
                }




                // Menambahkan total biaya ke dalam outputHTML
                let totalCost = getTotalCost(resultPrice);
                outputHTML += `<div class="row mt-3">
                        <div class="col">
                            <p>Total Biaya Keseluruhan: Rp ${parseFloat(totalCost).toLocaleString('id-ID')}</p>
                        </div>
                    </div>`;

                outputHTML += '<button type="submit" class="btn btn-primary mt-3">Submit</button>';

                // Mengubah elemen HTML dengan id 'hasilPerhitungan' dengan outputHTML
                document.getElementById('output').innerHTML = outputHTML;
            }

            // Fungsi untuk menghitung total biaya
            function getTotalCost(resultPrice) {
                let totalCost = 0;
                for (let i = 0; i < resultPrice.length; i++) {
                    for (let j = 0; j < resultPrice[i].length; j++) {
                        totalCost += resultPrice[i][j];
                    }
                }
                return totalCost;
            }



            // function printRouteToForm(origin, destination, resultMatrix, resultPrice) {
            //     let form = document.getElementById('routeForm');
            //     for (let i = 0; i < origin.length; i++) {
            //         for (let j = 0; j < destination.length; j++) {
            //             if (resultMatrix[i][j] !== 0) {
            //                 let cost = resultPrice[i][j];
            //                 let quantity = resultMatrix[i][j].split('.')[1];
            //                 let input = document.createElement('input');
            //                 input.setAttribute('type', 'text');
            //                 input.setAttribute('name', 'route');
            //                 input.setAttribute('value',
            //                     `${origin[i]} => ${destination[j]} = ${quantity} Kg yang di distribusikan , Biaya => ${cost}`
            //                 );
            //                 form.appendChild(input);
            //             }
            //         }
            //     }
            // }




            function main() {


                if (need.reduce((acc, curr) => acc + curr, 0) > availability.reduce((acc, curr) => acc +
                        curr, 0)) {
                    insertArtificialOrigin(matrix, origin, destination, need, availability);
                } else if (availability.reduce((acc, curr) => acc + curr, 0) > need.reduce((acc, curr) =>
                        acc +
                        curr, 0)) {
                    insertArtificialDestination(matrix, destination, availability);
                }

                resultMatrix = resetResultMatrix(matrix);
                resultPrice = resetResultMatrix(matrix);

                while (sumWithoutNone(availability) + sumWithoutNone(need) !== 0) {
                    let [originPenalty, destinationPenalty] = calculatePenalties(matrix, need,
                        availability);
                    let [indexColumnNeed, lowerCostValue, indexLineAvailability] = findLowerCell(
                        originPenalty,
                        destinationPenalty, matrix, need, availability);
                    let valueAvailability = availability[indexLineAvailability];
                    let valueNeed = need[indexColumnNeed];

                    if (valueNeed < valueAvailability) {
                        resultMatrix[indexLineAvailability][indexColumnNeed] = lowerCostValue + '.' +
                            valueNeed;
                        resultPrice[indexLineAvailability][indexColumnNeed] = lowerCostValue * valueNeed;
                        for (let i = 0; i < matrix.length; i++) {
                            matrix[i][indexColumnNeed] = 0;
                        }
                        need[indexColumnNeed] = null;
                        availability[indexLineAvailability] -= valueNeed;

                    } else {
                        resultMatrix[indexLineAvailability][indexColumnNeed] = lowerCostValue + '.' +
                            valueAvailability;
                        resultPrice[indexLineAvailability][indexColumnNeed] = lowerCostValue *
                            valueAvailability;
                        for (let i = 0; i < matrix[0].length; i++) {
                            matrix[indexLineAvailability][i] = 0;
                        }
                        availability[indexLineAvailability] = null;
                        need[indexColumnNeed] -= valueAvailability;
                    }
                }

                printMatrix(resultMatrix, origin, destination);


                // // Output rute dengan biaya per unit yang terisi
                // printRoute(origin, destination, resultMatrix, resultPrice, matrix);
                printRouteToHTML(origin, destination, resultMatrix, resultPrice, matrix);
                // printRouteToForm(origin, destination, resultMatrix, resultPrice, matrix);
                console.log('Total biaya: ' + calculateResult(resultPrice));
            }


            main();



        });
    </script>






@endsection
