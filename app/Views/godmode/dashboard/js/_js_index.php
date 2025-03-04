<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"></script>

<script>
    // Tab functionality
    $(document).ready(function() {
        console.log("Document ready, initializing tabs");

        // Default active tab
        let activeTab = localStorage.getItem('activeTab') || 'pn-global';
        console.log("Active tab from localStorage:", activeTab);

        // Set active tab on load
        $('.tab-item[data-tab="' + activeTab + '"]').addClass('active').css({
            'background-color': '#BFA573',
            'color': '#000'
        });
        $('#' + activeTab).addClass('active').css('display', 'block');

        // Tab click handler
        $('.tab-item').click(function() {
            const tabId = $(this).data('tab');
            console.log("Tab clicked:", tabId);

            // Remove active class and reset styles from all tabs and contents
            $('.tab-item').removeClass('active').css({
                'background-color': '#444',
                'color': '#fff'
            });
            $('.tab-content').removeClass('active').css('display', 'none');

            // Add active class and styles to clicked tab and its content
            $(this).addClass('active').css({
                'background-color': '#BFA573',
                'color': '#000'
            });
            $('#' + tabId).addClass('active').css('display', 'block');

            // Save active tab to localStorage
            localStorage.setItem('activeTab', tabId);
        });
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);


    $('#table_totalmember').DataTable({
        "pageLength": 100,
        "scrollX": true,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_totalmember",
            "type": "POST",
            "dataSrc": function(data) {
                return data.message;
                console.log(data.message);
            }
        },
        "columns": [{
                data: 'email'
            },
            {
                data: 'refcode'
            },
            // {
            //     data: "created_at",
            //     "mRender": function(data, type, full, meta) {
            //         var date = new Date(data);
            //         var options = {
            //             day: '2-digit',
            //             month: 'short',
            //             year: 'numeric'
            //         };
            //         return date.toLocaleDateString('en-GB', options);
            //     }
            // },
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
                data: null,
                "mRender": function(data, type, full, meta) {
                    // Jika salah satu atau kedua nilai start_date dan end_date null, tampilkan "Inactive"
                    if (!full.start_date || !full.end_date) {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }

                    var start = moment(full.start_date, "YYYY-MM-DD HH:mm:ss");
                    var end = moment(full.end_date, "YYYY-MM-DD HH:mm:ss");

                    // Jika format tanggal tidak valid, juga tampilkan "Inactive"
                    if (!start.isValid() || !end.isValid()) {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }

                    var diffDays = end.diff(start, 'days');
                    return diffDays + " days";
                }
            },
            {
                data: 'referral'
            },
            {
                data: 'initial_capital'
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    var btndetail = '';
                    btndetail = `<a href="<?= BASE_URL ?>godmode/dashboard/detailmember/${encodeURI(btoa(full.email))}/${full.id}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`

                    // Button disable/enable
                    if (full.status == 'active') {
                        btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="disabledmember('` + full.email + `')"><svg  width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M368 128c0 44.4-25.4 83.5-64 106.4l0 21.6c0 17.7-14.3 32-32 32l-96 0c-17.7 0-32-14.3-32-32l0-21.6c-38.6-23-64-62.1-64-106.4C80 57.3 144.5 0 224 0s144 57.3 144 128zM168 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm144-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM3.4 273.7c7.9-15.8 27.1-22.2 42.9-14.3L224 348.2l177.7-88.8c15.8-7.9 35-1.5 42.9 14.3s1.5 35-14.3 42.9L295.6 384l134.8 67.4c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L224 419.8 46.3 508.6c-15.8 7.9-35 1.5-42.9-14.3s-1.5-35 14.3-42.9L152.4 384 17.7 316.6C1.9 308.7-4.5 289.5 3.4 273.7z"/></svg></a>`
                    } else {
                        btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="enablemember('` + full.email + `')"><svg  width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 352l0-96 16 0 0 96-16 0zm-64 0l-88 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l120 0 80 0 376 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-344 0 0-191.1 28.6 47.5c9.1 15.1 28.8 20 43.9 10.9s20-28.8 10.9-43.9l-58.3-97c-17.4-28.9-48.6-46.6-82.3-46.6l-29.7 0c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9 120 448zM598.6 121.4l-80-80c-12.5-12.5-32.8-12.5-45.3 0l-80 80c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L464 141.3 464 384c0 17.7 14.3 32 32 32s32-14.3 32-32l0-242.7 25.4 25.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"/></svg>`
                    }

                    // Button delete
                    btndetail = btndetail + `&nbsp;&nbsp;<a href="#" onclick="deletemember('` + full.email + `')"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#BFA573" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a>`;
                    return btndetail;
                }
            },

        ],

    });

    function deletemember(email) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/deletemember/" + encodeURI(btoa(email)));
        }
    }

    function disabledmember(email) {
        if (confirm("Are you sure you want to disabled this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/set_statusmember/" + encodeURI(btoa(email)) + "/disabled");
        }
    }

    function enablemember(email) {
        if (confirm("Are you sure you want to activate this user?")) {
            window.location.replace("<?= BASE_URL ?>godmode/dashboard/set_statusmember/" + encodeURI(btoa(email)) + "/active");
        }
    }

    $('#table_freemember').DataTable({
        "pageLength": 100,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_freemember",
            "type": "POST",
            "dataSrc": function(data) {
                return data.message;
                console.log(data.message);
            }
        },
        "columns": [{
                data: 'email',
            },
            {
                data: 'refcode',
            },
            {
                data: 'start_date',
            },
            {
                data: 'end_date',
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="<?= BASE_URL ?>godmode/dashboard/detailmember/${encodeURI(btoa(full.email))}/${full.id}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return btndetail;
                },
            },

        ],
    });

    // DataTable untuk Satoshi Signal
    $('#table_signals').DataTable({
        "pageLength": 100,
        "scrollX": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/signals/get_signals",
            "type": "POST",
            "dataSrc": function(data) {
                return data.message || [];
            }
        },
        "columns": [{
                data: "created_at",
                "mRender": function(data, type, full, meta) {
                    var date = new Date(data);
                    var options = {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    };
                    return date.toLocaleDateString('en-GB', options);
                }
            },
            {
                data: 'pair'
            },
            {
                data: 'type',
                "mRender": function(data, type, full, meta) {
                    if (data.toLowerCase() === 'buy') {
                        return '<span style="color: #0E7304; font-weight: bold;">BUY</span>';
                    } else {
                        return '<span style="color: #FF0000; font-weight: bold;">SELL</span>';
                    }
                }
            },
            {
                data: 'entry_price'
            },
            {
                data: 'target_price'
            },
            {
                data: 'stop_loss'
            },
            {
                data: 'status',
                "mRender": function(data, type, full, meta) {
                    if (data === 'active') {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
                                    Active
                                </div>`;
                    } else if (data === 'completed') {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#BFA573"/></svg>
                                    Completed
                                </div>`;
                    } else {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Cancelled
                                </div>`;
                    }
                }
            },
            {
                data: null,
                "mRender": function(data, type, full, meta) {
                    var btndetail = `<a href="<?= BASE_URL ?>godmode/signals/detail/${full.id}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`;

                    if (full.status === 'active') {
                        btndetail += `&nbsp;&nbsp;<a href="#" onclick="completeSignal(${full.id})"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#BFA573" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg></a>`;
                        btndetail += `&nbsp;&nbsp;<a href="#" onclick="cancelSignal(${full.id})"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#BFA573" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></a>`;
                    }

                    return btndetail;
                }
            }
        ]
    });

    // Fungsi untuk menangani signal
    function completeSignal(id) {
        if (confirm("Apakah Anda yakin ingin menandai sinyal ini sebagai selesai?")) {
            window.location.replace("<?= BASE_URL ?>godmode/signals/complete_signal/" + id);
        }
    }

    function cancelSignal(id) {
        if (confirm("Apakah Anda yakin ingin membatalkan sinyal ini?")) {
            window.location.replace("<?= BASE_URL ?>godmode/signals/cancel_signal/" + id);
        }
    }
</script>