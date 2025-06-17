 <script>
    const url = new URL(window.location.href);
    const type = <?= json_encode($type); ?>;
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": `<?= BASE_URL ?>godmode/dashboard/get_downline/${type}/<?=$member->id?>`,
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            }
        },
        "columns": [
            { data: 'email'},
            { data: 'status'},
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    var subscription='';
                    if (parseInt(full.day)>0){
                        subscription = full.day + "days until "+full.end_date;
                    }
                    return subscription;
                } 
            },
        ],
    });
    
    $('#table_level').DataTable({
        "pageLength": 50,
        "dom": '<"d-flex justify-content-between align-items-center flex-wrap"lf>t<"d-flex justify-content-between align-items-center"ip>',
        "responsive": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/dashboard/getlevel_downline/<?=$member->id?>/2",
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            }
        },
        "columns": [
            { data: 'email'},
            { data: 'status'},
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    var subscription='';
                    if (parseInt(full.day)>0){
                        subscription = full.day + "days until "+full.end_date;
                    }
                    return subscription;
                } 
            },
        ],
    });

    
    function validate() {
        return confirm("Are you sure you want to give a bonus to this user?");
    }

 </script>