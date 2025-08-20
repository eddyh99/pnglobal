<script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>
<script>
    $(document).ready(function() {
        var table = $('#principe-table').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            "responsive": true,
            "pageLength": 100,
            "ajax": {
                "url": "<?=BASE_URL?>godmode/principe/get_detailprofit",
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
                // Comm Buy = prezzo buy / 100 * 0.1
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

                // Ambil seluruh data tanpa filter
                var allData = settings.json;

                if (!allData || allData.length === 0) {
                    $('#totalOpFondo').text('0.00');
                    $('#totalNetStorCli').text('0.00');
                    $('#messe').text('0');
                    $('#media\\%mese').text('0.00');
                    return;
                }

                var totalOpFondo = 0;
                var totalNetStorCli = 0;
                var uniqueMonths = new Set();

                // === Array untuk menampung hasil perhitungan ===
                var calculationResults = [];

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
    
                        if (row.closed_sell) {
                            uniqueMonths.add(row.closed_sell.substring(0, 7));
                        }
    
                        // === Push hasil perhitungan ke dalam array ===
                        calculationResults.push({
                            buyPrice: buyPrice,
                            sellPrice: sellPrice,
                            commBuy: commBuy.toFixed(2),
                            commSell: commSell.toFixed(2),
                            net: net.toFixed(2),
                            opFondo: opFondo.toFixed(9),
                            netStorCli: netStorCli.toFixed(9)
                        });
                    }
                });

                var messe = uniqueMonths.size;
                var mediaPerMese = (messe > 0) ? (totalNetStorCli / messe) : 0;

                // Memperbarui elemen di dalam card
                $('#totalOpFondo').text(totalOpFondo.toFixed(4));
                $('#totalNetStorCli').text(totalNetStorCli.toFixed(4));
                $('#messe').text(messe);
                // Perhatikan penggunaan \\ untuk karakter % pada selector
                $('#media\\%mese').text(mediaPerMese.toFixed(4));

                // // === Tampilkan tabel di console log ===
                // console.log("Hasil Perhitungan Untuk Setiap Baris:");
                // console.table(calculationResults);
                // console.log("Total Op Fondo: " + totalOpFondo.toFixed(9));
                // console.log("Total Net Storage Client: " + totalNetStorCli.toFixed(9));
                // console.log("Total Month: " + messe);
                // console.log("Media % Month: " + mediaPerMese.toFixed(9));
            }
        });

        $('#bulan_filter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>