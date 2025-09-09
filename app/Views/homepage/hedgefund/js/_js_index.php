<style>
    /* ===== Custom Hedgefund Table Style ===== */
    #principe-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #B48B3D;
        border-radius: 8px;
        overflow: hidden;
        background: #0f0f0f;
    }

    /* Header */
    #principe-table thead {
        background: #bfa573;
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
    }

    #principe-table thead th {
        padding: 14px;
        border-right: 1px solid #00000033;
        text-align: center;
    }

    /* Body row text putih */
    #principe-table tbody td {
        padding: 12px;
        text-align: center;
        border-top: 1px solid #222;
        color: #fff !important;
        /* paksa semua isi jadi putih */
    }

    /* Kalau ada row dengan class bawaan DataTables */
    #principe-table tbody tr.odd td,
    #principe-table tbody tr.even td {
        color: #fff !important;
        background-color: #111 !important;
        /* biar konsisten gelap */
    }



    /* DataTables controls (search, length, info, pagination) */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: #fff;
    }

    /* Search box & select */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        /* background: #111;
        color: #fff; */
        border: 1px solid #B48B3D;
        border-radius: 6px;
        padding: 5px 8px;
    }

    /* Wrapper layout */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin: 10px 0;
        color: #fff;
        font-weight: 500;
    }

    /* Label */
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #fff;
    }

    /* Dropdown (Show entries) */
    .dataTables_wrapper .dataTables_length select {
        background-color: #111;
        border: 1px solid #B48B3D;
        color: #fff;
        border-radius: 6px;
        padding: 4px 8px;
        margin: 0 5px;
        font-weight: 500;
    }

    /* Search input */
    .dataTables_wrapper .dataTables_filter input {
        background-color: #111;
        border: 1px solid #B48B3D;
        color: #fff;
        border-radius: 6px;
        padding: 5px 10px;
        margin-left: 8px;
        width: 200px;
    }

    /* Focus effect */
    .dataTables_wrapper select:focus,
    .dataTables_wrapper input:focus {
        outline: none;
        box-shadow: 0 0 5px #B48B3D;
    }

    .d-block {
        display: block !important;
    }

    .iq-card {
        background: linear-gradient(107deg, #B48B3D 49.78%, #BFA573 100%) !important;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
        margin-bottom: 30px;
        border: none;
        -webkit-box-shadow: 0px 4px 20px 0px rgba(44, 101, 144, 0.1);
        box-shadow: 0px 4px 20px 0px rgba(44, 101, 144, 0.1);
    }

    .iq-card-body {
        padding: 20px;
    }

    .h-100 {
        height: 100% !important;
    }

    .page-item.active .page-link {
        background-color: #B48B3D !important;
        border-color: #B48B3D !important;
    }

    page-link {
        background-color: #B48B3D !important;
        border-color: #B48B3D !important;
    }

    .my-font-section {
        font-family: "Poppins", Arial, sans-serif;
        /* contoh font */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


<!-- <script>
    $(document).ready(function() {
        var table = $('#principe-table').DataTable({
            dom: '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            responsive: true,
            pageLength: 100,
            ajax: {
                url: "<?= BASE_URL ?>hedgefund_data",
                type: "POST",
                // ⬇️ cek apakah server return array langsung atau dalam key "data"
                dataSrc: function(json) {
                    // kalau server return {data: [...]}
                    if (json.data) json = json.data;

                    let filterBulan = $('#bulan_filter').val();
                    if (filterBulan) {
                        return json.filter(item => item.closed_sell && item.closed_sell.startsWith(filterBulan));
                    }
                    return json;
                }
            },
            columns: [{
                    data: 'buy_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'sell_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var buyPrice = parseFloat(row.buy_price) || 0;
                        var commBuy = (buyPrice / 100) * 0.1;
                        return commBuy.toFixed(2);
                    }
                },
                // Comm Sell = prezzo sell / 100 * 0.1
                {
                    data: null,
                    render: function(data, type, row) {
                        var sellPrice = parseFloat(row.sell_price) || 0;
                        var commSell = (sellPrice / 100) * 0.1;
                        return commSell.toFixed(2);
                    }
                },
                // Net = prezzo sell - prezzo buy - comm buy - comm sell
                {
                    data: null,
                    render: function(data, type, row) {
                        var buyPrice = parseFloat(row.buy_price) || 0;
                        var sellPrice = parseFloat(row.sell_price) || 0;
                        var commBuy = (buyPrice / 100) * 0.1;
                        var commSell = (sellPrice / 100) * 0.1;
                        var net = sellPrice - buyPrice - commBuy - commSell;
                        return net.toFixed(2);
                    }
                },
                // Op Fondo = net / prezzo buy * 100
                {
                    data: null,
                    render: function(data, type, row) {
                        var buyPrice = parseFloat(row.buy_price) || 0;
                        var sellPrice = parseFloat(row.sell_price) || 0;
                        var commBuy = (buyPrice / 100) * 0.1;
                        var commSell = (sellPrice / 100) * 0.1;
                        var net = sellPrice - buyPrice - commBuy - commSell;

                        if (buyPrice === 0) {
                            return "0.00"; // Hindari pembagian dengan nol
                        }
                        var opFondo = (net / buyPrice) * 100;
                        return opFondo.toFixed(4);
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let buyPrice = parseFloat(row.buy_price) || 0;
                        let sellPrice = parseFloat(row.sell_price) || 0;
                        let commBuy = (buyPrice / 100) * 0.1;
                        let commSell = (sellPrice / 100) * 0.1;
                        let net = sellPrice - buyPrice - commBuy - commSell;

                        if (buyPrice === 0) return "0.0000";
                        let opFondo = (net / buyPrice) * 100;
                        let netStorCli = (opFondo / 2) / 4;
                        return netStorCli.toFixed(4);
                    }
                }
            ],
            drawCallback: function() {
                let api = this.api();
                let allData = api.ajax.json(); // ✅ cara ambil data di v1.13+

                if (!allData) {
                    $('#month').text('0');
                    $('#average_month').text('0.0000');
                    return;
                }

                // kalau server return {data: [...]} → ambil arraynya
                if (allData.data) allData = allData.data;

                let totalOpFondo = 0;
                let totalNetStorCli = 0;
                let uniqueMonths = new Set();

                allData.forEach(row => {
                    let buyPrice = parseFloat(row.buy_price) || 0;
                    let sellPrice = parseFloat(row.sell_price) || 0;
                    let commBuy = (buyPrice / 100) * 0.1;
                    let commSell = (sellPrice / 100) * 0.1;
                    let net = sellPrice - buyPrice - commBuy - commSell;

                    if (buyPrice !== 0) {
                        let opFondo = (net / buyPrice) * 100;
                        let netStorCli = (opFondo / 2) / 4;
                        totalOpFondo += opFondo;
                        totalNetStorCli += netStorCli;
                    }

                    if (row.closed_sell) {
                        uniqueMonths.add(row.closed_sell.substring(0, 7));
                    }
                });

                let messe = uniqueMonths.size;
                let mediaPerMese = messe > 0 ? (totalNetStorCli / messe) : 0;

                $('#totalOpFondo').text(totalOpFondo.toFixed(4));
                $('#totalNetStorCli').text(totalNetStorCli.toFixed(4));
                $('#month').text(messe);
                $('#average_month').text(mediaPerMese.toFixed(4));
            }
        });

        $('#bulan_filter').on('change', function() {
            table.ajax.reload();
        });
    });
</script> -->

<script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>
<script>
    $(document).ready(function() {
        var table = $('#principe-table').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            "responsive": true,
            "pageLength": 100,
            "ajax": {
                "url": "<?= BASE_URL ?>hedgefund_data",
                "type": "POST",
                "dataSrc": function(data) {
                    var filterBulan = $('#bulan_filter').val();
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
                // Kolom Prezzo Buy
                {
                    data: 'buy_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                // Kolom Prezzo Sell
                {
                    data: 'sell_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                // // Comm Buy = prezzo buy / 100 * 0.1
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         var buyPrice = parseFloat(row.buy_price) || 0;
                //         var commBuy = (buyPrice / 100) * 0.1;
                //         return commBuy.toFixed(2);
                //     }
                // },
                // // Comm Sell = prezzo sell / 100 * 0.1
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         var sellPrice = parseFloat(row.sell_price) || 0;
                //         var commSell = (sellPrice / 100) * 0.1;
                //         return commSell.toFixed(2);
                //     }
                // },
                // // Net = prezzo sell - prezzo buy - comm buy - comm sell
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         var buyPrice = parseFloat(row.buy_price) || 0;
                //         var sellPrice = parseFloat(row.sell_price) || 0;
                //         var commBuy = (buyPrice / 100) * 0.1;
                //         var commSell = (sellPrice / 100) * 0.1;
                //         var net = sellPrice - buyPrice - commBuy - commSell;
                //         return net.toFixed(2);
                //     }
                // },
                // // Op Fondo = net / prezzo buy * 100
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         var buyPrice = parseFloat(row.buy_price) || 0;
                //         var sellPrice = parseFloat(row.sell_price) || 0;
                //         var commBuy = (buyPrice / 100) * 0.1;
                //         var commSell = (sellPrice / 100) * 0.1;
                //         var net = sellPrice - buyPrice - commBuy - commSell;

                //         if (buyPrice === 0) {
                //             return "0.00"; // Hindari pembagian dengan nol
                //         }
                //         var opFondo = (net / buyPrice) * 100;
                //         return opFondo.toFixed(4);
                //     }
                // },
                // Net Stor Cli = op fondo / 2 / 4
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
                }
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var allData = settings.json;
            
                if (!allData || allData.length === 0) {
                    $('#totalOpFondo').text('0.00');
                    $('#totalNetStorCli').text('0.00');
                    $('#month').text('0');
                    $('#average_month').text('0.00');
                    return;
                }
            
                var totalOpFondo = 0;
                var totalNetStorCli = 0;
                var allMonths = [];
            
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
            
                        // simpan bulan transaksi dalam format YYYY-MM
                        allMonths.push(row.closed_sell.substring(0, 7));
                    }
                });
            
                // === Hitung messe berdasarkan bulan pertama transaksi s/d bulan sekarang ===
                var messe = 0;
                if (allMonths.length > 0) {
                    allMonths.sort(); // urutkan
                    var minMonth = allMonths[0]; // bulan pertama
                    var [minYear, minMon] = minMonth.split("-").map(Number);
            
                    var now = new Date();
                    var curYear = now.getFullYear();
                    var curMon = now.getMonth() + 1;
            
                    messe = (curYear - minYear) * 12 + (curMon - minMon) + 1;
                }
            
                var mediaPerMese = (messe > 0) ? (totalNetStorCli / messe) : 0;
            
                $('#totalOpFondo').text(totalOpFondo.toFixed(4));
                $('#totalNetStorCli').text(totalNetStorCli.toFixed(4));
                $('#month').text(messe);
                $('#average_month').text(mediaPerMese.toFixed(4));
            }

        });

        $('#bulan_filter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>