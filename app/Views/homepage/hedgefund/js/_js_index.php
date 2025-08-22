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
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


<script>
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
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    data: 'sell_price',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
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
                        totalNetStorCli += netStorCli;
                    }

                    if (row.closed_sell) {
                        uniqueMonths.add(row.closed_sell.substring(0, 7));
                    }
                });

                let messe = uniqueMonths.size;
                let mediaPerMese = messe > 0 ? (totalNetStorCli / messe) : 0;

                $('#month').text(messe);
                $('#average_month').text(mediaPerMese.toFixed(4));
            }
        });

        $('#bulan_filter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>