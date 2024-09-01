$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        buttons: [
            {
                extend: 'csv',
                text: 'Export CSV',
                exportOptions: {
                    columns: ':not(:last-child)' // Mengabaikan kolom terakhir
                }
            },
            {
                extend: 'pdf',
                text: 'Export PDF',
                exportOptions: {
                    columns: ':not(:last-child)' // Mengabaikan kolom terakhir
                }
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)' // Mengabaikan kolom terakhir
                }
            }
        ]
    });

    // Sembunyikan tombol CSV, PDF, dan Print
    $('.buttons-csv').hide();
    $('.buttons-pdf').hide();
    $('.buttons-print').hide();


            // Handle CSV export button click
            $('#exportCsv').on('click', function() {
                table.button('.buttons-csv').trigger();
            });

            // Handle PDF export button click
            $('#exportPdf').on('click', function() {
                table.button('.buttons-pdf').trigger();
            });

            // Handle Print button click
            $('#exportPrint').on('click', function() {
                table.button('.buttons-print').trigger();
            });
});


        // $(document).ready(function() {
        //     var table = $('#dataTable').DataTable();

        //     // Handle CSV export button click
        //     $('#exportCsv').on('click', function() {
        //         table.button('.buttons-csv').trigger();
        //     });

        //     // Handle PDF export button click
        //     $('#exportPdf').on('click', function() {
        //         table.button('.buttons-pdf').trigger();
        //     });

        //     // Handle Print button click
        //     $('#exportPrint').on('click', function() {
        //         table.button('.buttons-print').trigger();
        //     });
        // });
