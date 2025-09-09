<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/2.3.2/api/sum().js"></script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

    function deletemember(email) {
        if (confirm("Are you sure you want to delete this "+email+" ?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/deletemember/hedgefund/" + encodeURI(btoa(email)));
        }
    }

    function disabledmember(email) {
        if (confirm("Are you sure you want to disabled this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/set_statusmember/hedgefund/" + encodeURI(btoa(email)) + "/disabled");
        }
    }

    function enablemember(email) {
        if (confirm("Are you sure you want to activate this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/set_statusmember/hedgefund/" + encodeURI(btoa(email)) + "/active");
        }
    }

    // elite

    $('#table_totalmember_elite').DataTable({
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "pageLength": 100,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_totalmember_elite",
            "type": "POST",
            "dataSrc": function(data) {
                console.log(data);
                return data;
            }
        },
        drawCallback: function () {
          var api = this.api();
          var fund = api.column(5).data().sum();
          var trade = api.column(6).data().sum();
          api.column(5).footer().innerHTML = fund.toFixed(2).toLocaleString('en');
          api.column(6).footer().innerHTML = trade.toFixed(2).toLocaleString('en');
        },        
        "columns": [{
                data: 'email',
                render: function (data, type, row) {
                    if (type === 'display') {
                        // show shortened email in table
                        return data.length > 30 ? data.substr(0, 27) + "..." : data;
                    }
                    // for filter, sort, export → return full value
                    return data;
                }
            },
            {
                data: 'role',
                render: function (data, type, row) {
                    return data === 'referral' ? row.refcode : '';
                }
            },

            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    if (full.status == 'active') {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
                                    Active
                                </div>`;
                    } else if (full.status == 'new') {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#7F7F7F"/></svg>
                                    New
                                </div>`;

                    } else {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }
                }
            },
            {
                data: "has_deposit",
                className: "text-center",
                "mRender": function(data, type, full, meta) {
                    if (data== 1) {
                        return `<div> Deposit </div>`;
                    }else{
                        return '';
                    }
                }
            },            
            {
                data: 'referral'
            },
            {
                data: 'fund', render: $.fn.dataTable.render.number( ',', '.', 2, '' )
            },
            {
                data: 'trade', render: $.fn.dataTable.render.number( ',', '.', 2, '' )
            },
            {
                data: 'trade_btc', render: $.fn.dataTable.render.number( ',', '.', 6, '' )
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    var btndetail = '';
                    btndetail = `<a href="<?= BASE_URL ?>godmode/dashboard/detailmember/hedgefund/${encodeURI(btoa(full.email))}/<?= base64_encode("totalmember") ?>"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    if (full.status == 'active') {
                        btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="disabledmember('` + full.email + `')"><svg  width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M368 128c0 44.4-25.4 83.5-64 106.4l0 21.6c0 17.7-14.3 32-32 32l-96 0c-17.7 0-32-14.3-32-32l0-21.6c-38.6-23-64-62.1-64-106.4C80 57.3 144.5 0 224 0s144 57.3 144 128zM168 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm144-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM3.4 273.7c7.9-15.8 27.1-22.2 42.9-14.3L224 348.2l177.7-88.8c15.8-7.9 35-1.5 42.9 14.3s1.5 35-14.3 42.9L295.6 384l134.8 67.4c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L224 419.8 46.3 508.6c-15.8 7.9-35 1.5-42.9-14.3s-1.5-35 14.3-42.9L152.4 384 17.7 316.6C1.9 308.7-4.5 289.5 3.4 273.7z"/></svg></a>`
                    } else {
                        btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="enablemember('` + full.email + `')"><svg  width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 352l0-96 16 0 0 96-16 0zm-64 0l-88 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l120 0 80 0 376 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-344 0 0-191.1 28.6 47.5c9.1 15.1 28.8 20 43.9 10.9s20-28.8 10.9-43.9l-58.3-97c-17.4-28.9-48.6-46.6-82.3-46.6l-29.7 0c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9 120 448zM598.6 121.4l-80-80c-12.5-12.5-32.8-12.5-45.3 0l-80 80c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L464 141.3 464 384c0 17.7 14.3 32 32 32s32-14.3 32-32l0-242.7 25.4 25.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"/></svg>`
                    }
                    btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="deletemember('` + full.email + `')"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a>`;
                    return btndetail;
                }
            },

        ],

    });

    updateProfits();
    function updateProfits() {
        $.ajax({
            url: '<?= BASE_URL ?>godmode/hedge/get_profit', // Ganti dengan endpoint sesuai back-end kamu
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);

                var total = Number(response.fund_usdt)+Number(response.trade_usdt)+Number(response.commission);
                // Pastikan response punya struktur { fund_balance: ..., trade_balance: ... }
                $('#tprofit').text((+response.total_profit || 0).toLocaleString('en'));
                $('#cprofit').text((+response.client_profit || 0).toLocaleString('en'));
                $('#rprofit').text((+response.ref_comm || 0).toLocaleString('en'));
                $('#mprofit').text((+response.master_profit || 0).toLocaleString('en'));

            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil data balance:", error);
                $('#tprofit').text('Error');
                $('#cprofit').text('Error');
                $('#rprofit').text('Error');
                $('#mprofit').text('Error');
            }
        });
    }
</script>