<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?></title>

    <!-- Favicons -->
    <link href="<?= BASE_URL ?>assets/img/logo-big.png" rel="icon">
    <link href="<?= BASE_URL ?>assets/img/logo-big.png" rel="apple-touch-icon">

    <!-- Bootstrap CSS and DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }
        
        .custom-card {
            background-color: #406852;
            color: white;
            padding: 20px;
            border-radius: 10px;
            font-weight: bold;
            height: 150px;
            /* tentukan tinggi card */
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* label tetap di pojok kiri atas */
        .custom-card p {
            font-size: 0.9rem;
            font-weight: normal;
            text-align: left;
            margin: 0;
        }

        /* angka berada di tengah card */
        .custom-card h2 {
            margin: 0;
            flex: 1;
            display: flex;
            align-items: center;
            /*vertikal tengah */
            justify-content: center;
            /* horizontal tengah */
            font-size: 2.5rem;
        }


        /* HEADER TABEL */
        table.table-custom thead tr {
            background-color: #9fb3a8 !important;
        }

        table.table-custom thead th {
            background-color: #9fb3a8 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* ISI TABEL */
        table.table-custom tbody td {
            color: #406852 !important;
            font-weight: 600;
            text-align: center !important;
            vertical-align: middle !important;
            background-color: #ffffff !important;
        }

        /* BORDER TABEL MELENGKUNG */
        table.table-custom {
            border: 1px solid #406852;
            border-collapse: separate;
            /* supaya radius jalan */
            border-radius: 12px;
            overflow: hidden;
            background-color: #ffffff;
        }

        table.table-custom th,
        table.table-custom td {
            border: 1px solid #406852;
        }

        .container {
            max-width: 960px;
        }

        #selectMonth,
        #searchBox {
            border: 2px solid #406852;
            border-radius: 8px;
        }

        .dataTables_length,
        .dataTables_filter {
            display: none !important;
        }

        .dt-bottom .row {
            align-items: center;
        }

        .dt-bottom .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
        }

        /* Pagination */
        .pagination .page-link {
            color: #406852 !important;
            border: 1px solid #406852 !important;
            border-radius: 8px;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: #406852 !important;
            color: #fff !important;
            border: 1px solid #406852 !important;
        }
    </style>
</head>

<body>
    <?php
    if (isset($content)) {
        echo view($content);
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "dom": 'rt<"row dt-bottom mt-2"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>',
                "responsive": true,
                "pageLength": 10,
                "pagingType": "simple_numbers",
                "language": {
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                },
                "ajax": {
                    "url": "<?= BASE_URL ?>hedgefund_data",
                    "type": "POST",
                    "dataSrc": function(data) {
                        // filter by bulan (ambil dari #selectMonth)
                        var filterBulan = $('#selectMonth').val();
                        if (filterBulan) {
                            var filteredData = data.filter(function(item) {
                                if (item.closed_sell) {
                                    return item.closed_sell.startsWith(filterBulan);
                                }
                                return false;
                            });
                            return filteredData;
                        }
                        return data;
                    }
                },
                "columns": [
                    // Kolom BUY
                    {
                        data: 'buy_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    // Kolom SELL
                    {
                        data: 'sell_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    // Net Stor Cli dihitung manual
                    {
                        data: null,
                        render: function(data, type, row) {
                            var buyPrice = parseFloat(row.buy_price) || 0;
                            var sellPrice = parseFloat(row.sell_price) || 0;
                            var commBuy = (buyPrice / 100) * 0.1;
                            var commSell = (sellPrice / 100) * 0.1;
                            var net = sellPrice - buyPrice - commBuy - commSell;

                            if (buyPrice === 0) {
                                return "0.00";
                            }
                            var opFondo = (net / buyPrice) * 100;
                            var netStorCli = (opFondo / 2) / 4;
                            return netStorCli.toFixed(4);
                        }
                    },
                    // kolom DATE disembunyikan (untuk filter)
                    {
                        data: 'closed_sell',
                        visible: false
                    }
                ],
                drawCallback: function(settings) {
                    var api = this.api();

                    var allData = settings.json;
                    // console.table(allData);
                    if (!allData || allData.length === 0) {
                        $('#totalOpFondo').text('0.00');
                        $('#totalNetStorCli').text('0.00');
                        $('#month').text('0');
                        $('#average_month').text('0.00');
                        return;
                    }

                    var totalOpFondo = 0;
                    var totalNetStorCli = 0;
                    var uniqueMonths = new Set();

                    allData.forEach(function(row) {
                        if (row.closed_sell) {
                            var buyPrice = parseFloat(row.buy_price) || 0;
                            var sellPrice = parseFloat(row.sell_price) || 0;
                            var commBuy = (buyPrice / 100) * 0.1;
                            var commSell = (sellPrice / 100) * 0.1;
                            var net = sellPrice - buyPrice - commBuy - commSell;

                            if (buyPrice !== 0) {
                                var opFondo = (net / buyPrice) * 100;
                                var netStorCli = (opFondo / 2) / 4;

                                totalOpFondo += opFondo;
                                totalNetStorCli += netStorCli;
                            }

                            uniqueMonths.add(row.closed_sell.substring(0, 7));
                        }
                    });

                    var messe = uniqueMonths.size;
                    var mediaPerMese = (messe > 0) ? (totalNetStorCli / messe) : 0;

                    // $('#totalOpFondo').text(totalOpFondo.toFixed(4));
                    // $('#totalNetStorCli').text(totalNetStorCli.toFixed(4));
                    $('#month').text(messe);
                    $('#average_month').text(mediaPerMese.toFixed(4));
                }
            });

            // === Default bulan saat pertama kali load ===
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, "0");
            $("#selectMonth").val(`${year}-${month}`);

            // === Filter manual berdasarkan bulan ===
            $('#selectMonth').on('change', function() {
                table.ajax.reload();
            });

            // === Custom search box ===
            $("#searchBox").on("keyup", function() {
                table.search(this.value).draw();
            });
        });
    </script>

    <?php
    if (@isset($extra)) {
        echo view(@$extra);
    }
    ?>
</body>

</html>