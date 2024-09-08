
<!-- Datatables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<!-- Datatables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<style>
     #table_history_period_filter,
     #table_history_period_length, 
     #table_history_period_info, 
     thead {
          display: none;
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
     $('#table_history_period').DataTable({
          "pageLength": 25,
          "scrollX": true,
          "order": false,
     })
</script>
