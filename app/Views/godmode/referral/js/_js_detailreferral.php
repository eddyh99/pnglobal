 <script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
    });

 </script>