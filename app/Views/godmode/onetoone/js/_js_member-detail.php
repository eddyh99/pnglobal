<script>
    $('#tbl__detail_member').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": true,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/onetoone/dashboard/get_detailmember/<?= $id_member ?>",
            "type": "GET",
            "dataSrc": function(data) {
                return data.payment;
            }
        },
        "columns": [{
                data: null,
                title: "#",
                render: function(data, type, full, meta) {
                    return meta.row + 1;
                },
                orderable: true,
                searchable: false,
                width: "30px"
            },
            {
                title: "Status",
                data: 'status_invoice',
                render: function(data, type, full, meta) {
                    // return data ? 'Paid' : 'Unpaid';
                    if (data === null) {
                        return `<span class="text-muted">No transaction yet</span>`;
                    } else if (data === "unpaid") {
                        return `<span class="text-danger">Unpaid</span>`;
                    } else if (data === "paid") {
                        return `<span class="text-success">Paid</span>`;
                    }
                },
                searchable: true,
            },
            {
                title: "Invoice Date",
                data: 'invoice_date',
                searchable: true,
            },
            {
                title: "Invoice Link",
                data: 'invoice_link',
                render: function(data, type, full, meta) {
                    return `<a href="${data}" target="_blank">View Invoice</a>`;
                }
            }
        ],
        language: {
            emptyTable: "No Data"
        }
    });
</script>