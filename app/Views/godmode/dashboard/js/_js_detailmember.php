<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>
<script>

    const url = new URL(window.location.href);
    const type = <?= json_encode($type); ?>;
    $("#btnref").on("click", function() {
        const walletInput = document.getElementById('refcode');
        walletInput.select(); // Select the text
        walletInput.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(walletInput.value) // Copy to clipboard
            .then(() => {
                alert('Referral copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
    })

    $("#expired").datepicker();
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

    // $('#table_referralmember').DataTable({
    //     "pageLength": 100,
    //     "scrollX": true,
    //     "ajax": {
    //         "url": "<?= BASE_URL ?>godmode/dashboard/get_downline/" + $("#id").val(),
    //         "type": "POST",
    //         "dataSrc": function(data) {
    //             return data.message;
    //             console.log(data.message);
    //         },
    //         "data": function(d) {
    //             d.product = tab;
    //             // console.log(d.id_member);
    //         },
    //     },
    //     "columns": [{
    //             data: 'email'
    //         },
    //         {
    //             data: null,
    //             "mRender": function(data, type, full, meta) {
    //                 if (full.status == 'active') {
    //                     return `<div>
    //                                 <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
    //                                 Active
    //                             </div>`;
    //                 } else if (full.status == 'new') {
    //                     return `<div>
    //                                 <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#7F7F7F"/></svg>
    //                                 New
    //                             </div>`;

    //                 } else {
    //                     return `<div>
    //                                 <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
    //                                 Inactive
    //                             </div>`;
    //                 }
    //             }
    //         },
    //         {
    //             data: null,
    //             "mRender": function(data, type, full, meta) {
    //                 if (!full.start_date || !full.end_date) {
    //                     return `<div>
    //                                 <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
    //                                 Inactive
    //                             </div>`;
    //                 }

    //                 var start = moment(full.start_date, "YYYY-MM-DD HH:mm:ss");
    //                 var end = moment(full.end_date, "YYYY-MM-DD HH:mm:ss");

    //                 if (!start.isValid() || !end.isValid()) {
    //                     return `<div>
    //                                 <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
    //                                 Inactive
    //                             </div>`;
    //                 }

    //                 var diffDays = end.diff(start, 'days');
    //                 return diffDays + " days";
    //             }
    //         }
    //     ]
    // });

    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>godmode/dashboard/get_downline/${type}/` + $("#id").val(),
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(2).data().sum();
          api.column(2).footer().innerHTML = total.toFixed(2).toLocaleString('en');
        },
        "columns": [
            { data: 'email'},
            { data: 'status'},
            { data: 'komisi', render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
        ],
    });

    $('#table_commission').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>godmode/dashboard/get_comission/` + $("#id").val(),
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(1).data().sum();
          api.column(1).footer().innerHTML = total.toFixed(2).toLocaleString('en');
        },
        "columns": [
            { data: 'description'},
            { data: 'komisi', render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
        ],
    });
    
    $('#table_depositmember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>godmode/dashboard/get_deposit/${type}/` + $("#id").val(),
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data.filter(function (item) {
                    return item.status === 'complete';
                });						
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(1).data().sum();
          api.column(1).footer().innerHTML = total.toFixed(2).toLocaleString('en');
        },
        "columns": [
            { data: 'date'},
            { data: 'commission', render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
        ],
    });
    
    $('#table_transaction').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>godmode/dashboard/get_transaction/` + $("#id").val(),
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data.filter(function (item) {
                    return item.sell_price != null && item.master_profit!=null;
                });
                
            },
        },
        drawCallback: function () {
          var api = this.api();
          var total = api.column(6).data().sum();
          api.column(6).footer().innerHTML = total.toFixed(2).toLocaleString('en');
        },
        "columns": [
            {
                data: 'buy_type',
            },
            {
                data: 'buy_price',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                data: 'sell_price',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                data: 'amount_usdt',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
                data: 'amount_btc',
                render: $.fn.dataTable.render.number(',', '.', 8, '')
            },
            {
                data: null,
                render: function (data, type, row) {
                    // Calculate profit: sell_total_usdt - buy_total_usdt
                    if (row.sell_total_usdt==null){
                        return '';
                    }else{
                        const profit = parseFloat(row.sell_total_usdt || 0) - parseFloat(row.buy_total_usdt || 0);
                        return profit.toFixed(2);
                    }
                }
            },
            {
                data: 'client_profit',
                render: $.fn.dataTable.render.number(',', '.', 2, '')
            },
            {
              data: null,
              render: function (data, type, row) {
                if (row.sell_total_usdt == null) {
                  return '';
                }
            
                // 1) start with a numeric default
                var master = 0;
            
                if (row.total_commission == null) {
                  // 2) ensure both operands are numbers
                  const mp = parseFloat(row.master_profit)  || 0;
                  const cp = parseFloat(row.client_profit)  || 0;
            
                  // 3) subtract 10% of client_profit
                  const raw = mp - (cp * 0.1);
            
                  // 4) truncate down to 2 decimals
                  master = Math.floor(raw * 100) / 100;
            
                } else {
                  // commission is present — just use master_profit
                  master = parseFloat(row.master_profit) || 0;
                }
            
                // 5) format to exactly two decimals
                return master.toFixed(2);
              }
            },
            {
                data: 'total_commission',
                render: function (data, type, row) {
                    return (Math.floor(row.client_profit * 0.1 * 100) / 100).toFixed(2);
                }
            }
        ],
    });
    
    function validate() {
        return confirm("Are you sure you want to give a bonus to this user?");
    }

    $('#refcode').on('input', function() {
         let val = $(this).val().trim();
         let original = $(this).attr('data-refcode').trim();
         $('#changereff').prop('disabled', val === original || val === '');
     });
</script>