<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/bootstrap.min.css">
<!-- Typography CSS -->
<link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/typography.css">
<!-- Style CSS -->
<link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/responsive.css">
<!-- Datatables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<!-- Custom CSS -->
<link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/custom.css">

<!-- Datatables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<style>

.tr-data {
    border-bottom: #B48B3D;
}

.history-table-message{
    margin-top: 2rem;
}

.table {
    color: #FFFFFF;
}

.table thead th {
    border-bottom: none;
    background-color: transparent;
    color: #FFFFFF;
}

.table td {
    border-top: 1px solid #B48B3D;
    background-color: transparent;
    color: #FFFFFF;
    
}

.table th {
    border-top: none;
}

#table_message_wrapper {
    border: 2px solid #B48B3D;
}

#table_message_filter, #table_message_length {
    display:  none;
}

#table_message_length {
    padding: 0.5rem;
}

#table_message_length select{
    padding: 0.2rem;
}

#table_message_paginate,#table_message_info {
    padding: 1rem;
    color: #FFFFFF;
}
</style>

<script>


    $('#table_message').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
    });
</script>