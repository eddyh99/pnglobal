<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
 <script>
  $("#btnref").on("click",function(){
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
    
 $( "#expired" ).datepicker();
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
<?php
if($member->free_status=='free'){
?>
    $("#btnupgrade").hide();
    $("#btncancel").show();
<?php }else{?>
    $("#btnupgrade").show();
    $("#btncancel").hide();
<?php }?>

$('#table_referralmember').DataTable({
        "pageLength": 50,
        "scrollX": true,
        "order": false,
        "ajax": {
            "url": "<?= BASE_URL ?>godmode/dashboard/get_downline/<?=$member->id?>",
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
        "scrollX": true,
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