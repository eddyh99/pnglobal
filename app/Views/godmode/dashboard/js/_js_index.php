<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"></script>

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    
    $('#table_totalmember').DataTable({
        "pageLength": 25,
        "scrollX": true,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_totalmember",
            "type": "POST",
            "dataSrc":function (data){
                return data;							
            }
        },
        "columns": [
            { data: 'email' },
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    var date = new Date(data);
                    var options = { day: '2-digit', month: 'short', year: 'numeric' };
                    return date.toLocaleDateString('en-GB', options);
                } 
            },
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    if(full.status == 'active'){
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
                                    Active
                                </div>`;
                    }else if(full.status == 'new'){
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#7F7F7F"/></svg>
                                    New
                                </div>`;
                                
                    }else {
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#FF0000"/></svg>
                                    Inactive
                                </div>`;
                    }
                } 
            },
            { data: 'membership' },
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    const btndetail = `<a href="<?=BASE_URL?>godmode/dashboard/detailmember/<?= base64_encode("totalmember")?>/${encodeURI(btoa(full.email))}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
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
            "url": "<?= BASE_URL ?>godmode/member/get_freemember",
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            }
        },
        "columns": [
            { data: 'email'},
            { 
                data: "created_at", 
                "mRender": function(data, type, full, meta) {
                    var date = new Date(data);
                    var options = { day: '2-digit', month: 'short', year: 'numeric' };
                    return date.toLocaleDateString('en-GB', options);
                } 
            },
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    if(full.status == 'active'){
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#0E7304"/></svg>
                                    Active
                                </div>`;
                    }else if(full.status == 'new'){
                        return `<div>
                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" rx="4" fill="#7F7F7F"/></svg>
                                    New
                                </div>`;
                                
                    }else {
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
                    const btndetail = `<a href="<?=BASE_URL?>godmode/dashboard/detailmember/<?= base64_encode("freemember")?>/${encodeURI(btoa(full.email))}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return btndetail;
                } 
            },
            
        ],
    });
    
    $('#table_referralmember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/member/get_referralmember",
            "type": "POST",
            "dataSrc":function (data){
                console.log(data);
                return data;							
            }
        },
        "columns": [
            { data: 'email'},
            { data: 'total_referral'},
            { data: 'monthly_referral'},
            { data: 'total_unpaid_subscriptions'},
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    if(full.total_unpaid_commission == null){
                        return 0;
                    }
                    return parseInt(full.total_unpaid_commission) + " EUR";
                } 
            },
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    if(full.total_unpaid_commission_previous_month == null){
                        return 0;
                    }
                    return parseInt(full.total_unpaid_commission_previous_month) + " EUR";
                } 
            },
            { 
                data: null, 
                "mRender": function(data, type, full, meta) {
                    const btndisabled = `<a class="mx-2" href="<?=BASE_URL?>godmode/dashboard/detailreferral/<?= base64_encode("referralmember")?>/${encodeURI(btoa(full.email))}"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 21V19C16 17.9391 15.5786 16.9217 14.8284 16.1716C14.0783 15.4214 13.0609 15 12 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="#BFA573" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 11C10.7091 11 12.5 9.20914 12.5 7C12.5 4.79086 10.7091 3 8.5 3C6.29086 3 4.5 4.79086 4.5 7C4.5 9.20914 6.29086 11 8.5 11Z" stroke="#BFA573" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M23 11H17" stroke="#BFA573" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>`
                    const btndetail = `<a href="<?=BASE_URL?>godmode/dashboard/detailreferral/<?= base64_encode("referralmember")?>/${encodeURI(btoa(full.email))}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20 3.33333V20H3.33333V3.33333H20ZM17.7778 5.55556H5.55556V17.7778H17.7778V5.55556ZM16.6667 0V2.22222L2.22219 2.22219L2.22222 16.6667H0V0H16.6667ZM15.5556 12.2222V14.4444H7.77778V12.2222H15.5556ZM15.5556 7.77778V10H7.77778V7.77778H15.5556Z" fill="#BFA573"/></svg></a>`
                    return `${btndisabled} ${btndetail}`;
                } 
            },
            
        ],
    });
</script>