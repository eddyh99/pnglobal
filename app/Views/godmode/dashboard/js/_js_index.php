<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    
    $('#table_totalmember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/signal/list_history_order",
            "type": "POST",
            "dataSrc":function (data){
                return data;							
            }
        },
        "columns": [
            { data: 'type' },
            { 
                data: "entry_price", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        return parseFloat(data).toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        // Convert the date to the desired format
                        var date = new Date(data);
                        var day = ('0' + date.getDate()).slice(-2);
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear().toString().slice(-2);
                        return day + '/' + month + '/' + year;
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        // Extract the time (HH:mm) from the datetime string
                        var date = new Date(data);
                        var hours = ('0' + date.getHours()).slice(-2);
                        var minutes = ('0' + date.getMinutes()).slice(-2);
                        return hours + ':' + minutes;
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="<?=BASE_URL?>godmode/dashboard/detailmember"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return btndetail;
                } 
            },
            
        ],

    });
    
    $('#table_freemember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/signal/list_history_order",
            "type": "POST",
            "dataSrc":function (data){
                return data;							
            }
        },
        "columns": [
            { data: 'type' },
            { 
                data: "entry_price", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        return parseFloat(data).toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        // Convert the date to the desired format
                        var date = new Date(data);
                        var day = ('0' + date.getDate()).slice(-2);
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear().toString().slice(-2);
                        return day + '/' + month + '/' + year;
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    if (type === 'display') {
                        // Extract the time (HH:mm) from the datetime string
                        var date = new Date(data);
                        var hours = ('0' + date.getHours()).slice(-2);
                        var minutes = ('0' + date.getMinutes()).slice(-2);
                        return hours + ':' + minutes;
                    }
                    return data;
                } 
            },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="#"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return btndetail;
                } 
            },
            
        ],

    });
</script>