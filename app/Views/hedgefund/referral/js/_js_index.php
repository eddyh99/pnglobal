<style>
    .custom-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 10px;
        border: 2px solid #FAFAFA;
        background: linear-gradient(107deg, #737373 50.42%, #D2D1CE 100%);
    }

    .custom-card:hover:not(.active-card) {
        box-shadow: 0 0 15px rgba(180, 139, 61, 0.3);
    }

    .active-card,
    .custom-card.active-card {
        border-radius: 10px;
        border: 2px solid #B48B3D;
        background: linear-gradient(107deg, #B48B3D 50.42%, #BFA573 100%);
        box-shadow: 0 0 15px rgba(180, 139, 61, 0.5);
    }

    /* Menyesuaikan warna teks untuk card yang aktif */
    .active-card .card-row,
    .custom-card.active-card .card-row {
        color: white;
    }

    .qr-code-container {
        position: fixed;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        width: 200px;
        left: 52.5% !important;
        /* Override posisi left yang diberikan melalui JavaScript */
        transform: translateX(-50%);
        /* Memastikan QR code berada di tengah */
    }

    .qr-code-container button {
        background-color: #B48B3D;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Container untuk referral link dan QR code */
    .referral-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .referral-link-container {
        width: 50%;
    }

    .qr-code-section {
        width: 50%;
        text-align: right;
    }
    .btn-withdraw{
        display: inline-block;
        flex: 1;     
        border-radius: 10px;
        border: 2px solid #b48b3d;
        background: linear-gradient(107deg, #b48b3d 50.42%, #bfa573 100%);
        color: #000;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 600;
        line-height: normal;
        text-align: center;
        padding: 10px 20px;
        cursor: pointer;
        max-width:200px;
    }

    .btn-withdraw:hover {
        color: #000 !important;
    }    
    


</style>

<script>
    // Set tabel aktif secara default (referral)
    var activeTable = 'referral';

    // Aktifkan card referral secara default
    $('#card-referral').addClass('active-card');

    // Tambahkan style untuk card yang aktif
    function updateActiveCardStyle() {
        // Hapus semua kelas active-card terlebih dahulu
        $('.custom-card').removeClass('active-card');

        // Tambahkan kelas active-card ke card yang aktif
        if (activeTable === 'referral') {
            $('#card-referral').addClass('active-card');
        } else {
            $('#card-commission').addClass('active-card');
        }
    }

    // Fungsi untuk mengganti tabel yang ditampilkan
    function switchTable(table) {
        activeTable = table;

        if (table === 'referral') {
            $('#referral-content').show();
            $('#commission-content').hide();

            // Refresh DataTable jika sudah diinisialisasi
            if ($.fn.dataTable.isDataTable('#table_referral')) {
                $('#table_referral').DataTable().ajax.reload();
            }
        } else {
            $('#commission-content').show();
            $('#referral-content').hide();

            // Refresh DataTable jika sudah diinisialisasi
            if ($.fn.dataTable.isDataTable('#table_commission')) {
                $('#table_commission').DataTable().ajax.reload();
            }
        }

        // Perbarui style card yang aktif
        updateActiveCardStyle();
    }

    // Tambahkan event listener untuk card Total Referral
    $('#card-referral').on('click', function() {
        return;
        switchTable('referral');
    });

    // Tambahkan event listener untuk card Commission
    $('#card-commission').on('click', function() {
        switchTable('commission');
    });

    // Tambahkan styling untuk card yang bisa diklik
    $('.custom-card').css('cursor', 'pointer');

    // Set card aktif secara default
    updateActiveCardStyle();

    $.ajax({
        url: '<?= BASE_URL ?>hedgefund/referral/get_summary',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            // Cek jika response berhasil dan memiliki properti message.balance
            if (response && response.status && response.message && typeof response.message.referral !== "undefined" && typeof response.message.commission !== "undefined") {
                // Format angka: hilangkan koma desimal dan tambahkan pemisah ribuan

                console.log(response.message);
                var referral = response.message.referral;
                var commission = response.message.commission ?? 0;

                // Pastikan commission adalah angka
                commission = parseFloat(commission);

                // Format angka tanpa desimal
                var formattedCommission = commission;

                // Gunakan selector yang lebih spesifik untuk masing-masing card
                $('#card-referral .card-bottom').text(referral);
                $('#card-commission .card-bottom').text('$ ' + formattedCommission);
            } else {
                // Atur nilai default untuk kedua card
                $('#card-referral .card-bottom').text("0");
                $('#card-commission .card-bottom').text("$ 0");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // Atur nilai default jika terjadi error
            $('#card-referral .card-bottom').text("0");
            $('#card-commission .card-bottom').text("$ 0");
        }
    });

    var tableReferral = $('#table_referral').DataTable({
        // processing: true,
        serverSide: false,
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ajax: {
            url: '<?= BASE_URL ?>hedgefund/referral/get_referral',
            type: 'GET',
            dataSrc: function(response) {
                console.log('API Response:', response);
                if (response.status) {
                    return response.message;
                } else {
                    console.error('Error fetching data:', response.message);
                    return [];
                }
            }
        },
        columns: [
            {
                data: 'email'
            },
            {
                data: 'status'
            },
            // {
            //     data: 'subscription'
            // },
        ]
    });

    // Inisialisasi tabel Commission
    var tableCommission = $('#table_commission_reff').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": '<?= BASE_URL ?>hedgefund/referral/get_comission/',
            "type": "POST",
            "dataSrc":function (res){
                const data = res.data;
                
                const comReff = data.filter(item =>
                    item.description && item.description.toLowerCase().startsWith("deposit commission from")
                );
                return comReff;							
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(2).data().sum();
          api.column(2).footer().innerHTML = total.toLocaleString('en');
        },
        "columns": [
            { data: 'date'},
            { data: 'description'},
            { 
            data: 'commission', 
            render: function(data, type, row) {
                return $.fn.dataTable.render.number(',', '.', 2, '').display(Math.abs(data));
            } 
            }

        ],
    });

    $('#table_commission_trade').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": '<?= BASE_URL ?>hedgefund/referral/get_comission/',
            "type": "POST",
            "dataSrc":function (res){
                const data = res.data;
                
                const comTrade = data.filter(item =>
                    item.description && item.description.toLowerCase().startsWith("trade commission from")
                );
                return comTrade;							
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(2).data().sum();
          api.column(2).footer().innerHTML = total.toLocaleString('en');
        },
        "columns": [
            { data: 'date'},
            { data: 'description'},
            { 
            data: 'commission', 
            render: function(data, type, row) {
                return $.fn.dataTable.render.number(',', '.', 2, '').display(Math.abs(data));
            } 
            }

        ],
    });

    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>hedgefund/referral/get_downline/`,
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            },
        },
        // drawCallback: function () {
        //   var api = this.api();
        //   var total = api.column(1).data().sum();
        //   api.column(2).footer().innerHTML = total.toLocaleString('en');
        // },
        "columns": [
            { data: 'email'},
            {
                data: 'created_at',
                render: function (data, type, row) {
                    if (!data) return '';
                    const date = new Date(data);
                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                    return date.toLocaleDateString('en-GB', options); // Hasil: 12 Feb 2025
                }
            }
        ],
    });

</script>