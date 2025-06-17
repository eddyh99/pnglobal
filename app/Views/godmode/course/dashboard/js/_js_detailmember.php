<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
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

    $('#table_referralmember').DataTable({
        "pageLength": 100,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/dashboard/get_referralmember",
            "type": "POST",
            "dataSrc": function(data) {
                return data.message;
                console.log(data.message);
            },
            "data": function(d) {
                d.id_member = $('#id').val();
                console.log(d.id_member);
            },
        },
        "columns": [{
                data: 'email'
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
                data: null,
                "mRender": function(data, type, full, meta) {
                    if (!full.start_date || !full.end_date) {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }

                    var start = moment(full.start_date, "YYYY-MM-DD HH:mm:ss");
                    var end = moment(full.end_date, "YYYY-MM-DD HH:mm:ss");

                    if (!start.isValid() || !end.isValid()) {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }

                    var diffDays = end.diff(start, 'days');
                    return diffDays + " days";
                }
            }
        ]
    });

    <?php if ($tab === 'satoshi-signal') { ?>
        $('#table_referralmember_satoshi').DataTable({
            "pageLength": 50,
            "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            "responsive": true,
            "order": false,
            "ajax": {
                "url": "<?= BASE_URL ?>godmode/dashboard/get_downline/<?= $member->message->id ?>",
                "type": "POST",
                "dataSrc": function(data) {
                    console.log(data);
                    return data || [];
                }
            },
            "columns": [{
                    data: 'email'
                },
                {
                    data: 'status'
                },
                {
                    data: null,
                    "mRender": function(data, type, full, meta) {
                        var subscription = '';
                        if (parseInt(full.day) > 0) {
                            subscription = full.day + " days until " + full.end_date;
                        }
                        return subscription;
                    }
                }
            ]
        });

        $('#table_level').DataTable({
            "pageLength": 50,
            "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
            "responsive": true,
            "order": false,
            "ajax": {
                "url": "<?= BASE_URL ?>godmode/dashboard/getlevel_downline/<?= $member->message->id ?>/2",
                "type": "POST",
                "dataSrc": function(data) {
                    console.log(data);
                    return data || [];
                }
            },
            "columns": [{
                    data: 'email'
                },
                {
                    data: 'status'
                },
                {
                    data: null,
                    "mRender": function(data, type, full, meta) {
                        var subscription = '';
                        if (parseInt(full.day) > 0) {
                            subscription = full.day + " days until " + full.end_date;
                        }
                        return subscription;
                    }
                }
            ]
        });
    <?php } ?>

    function validate() {
        return confirm("Are you sure you want to give a bonus to this user?");
    }
</script>