<script>
    // Tab functionality
    $(document).ready(function() {

        $('#table_elitebtc_requestpayment').DataTable({
            "pageLength": 50,
            "scrollX": true,
            "order": false,
            "ajax": {
                "url": "<?= BASE_URL ?>godmode/payment/get_elitebtc_requestpayment",
                "type": "POST",
                "dataSrc": function(data) {
                    if (data.code === 404 || !data.message || !Array.isArray(data.message)) {
                        return [];
                    } else {
                        return data.message;
                    }
                }
            },
            "columns": [{
                    data: 'email'
                },
                {
                    data: 'requested_at'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'withdraw_type',
                    className: 'text-uppercase'
                },
                {
                    data: null,
                    "mRender": function(data, type, full, meta) {
                        const btndetail = `<a href="<?= BASE_URL ?>godmode/payment/detailpayment_hedgefund/${full.id}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                        return btndetail;
                    }
                },
            ],
            "language": {
                "emptyTable": "No data available"
            }
        });
    });
</script>