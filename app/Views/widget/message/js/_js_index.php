<style>
    #table_message_filter,
    #table_message_length, 
    #table_message_info{
        display: none;
    }

    
    th, td {
        background-color: transparent !important;
        font-size: 14px;
        color: #FFFFFF !important;
    }
    
    td {
        border: 1px solid #BFA573 !important;
        border-bottom: 1px solid #BFA573 !important;
    }
    
    th {
        border: 1px solid #BFA573 !important;
        border-bottom: none !important;
    }
    
    tr td:nth-child(1){
        border-right: none !important;
    }

    tr td:nth-child(2){
        border-left: none !important;
    }

    .active>.page-link, .page-link.active{
        background-color: #B48B3D !important;
        border-color: #B48B3D;
        color: #FFFFFF !important;
    }

    .page-link  {
        color: #B48B3D;
    }
</style>

<script>
    $('#table_message').DataTable({
        "pageLength": 25,
        "scrollX": true,
        "order": false,
    });
</script>