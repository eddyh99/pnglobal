<style>
    .custom-modal-bg {
        background-color: #bda069 !important;
        color: #fff;
        border-radius: 10px;
    }
    .custom-modal-bg .modal-header {
        border-bottom: none;
    }
    .custom-modal-bg .modal-footer {
        border-top: none;
    }
    .custom-modal-size {
        max-height: 400px; /* Adjust this to make it bigger */
    }
    .btn-withdraw{
        color: #000 !important;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 600;
        line-height: normal;
        text-align: center;
        padding: 10px 20px;
        cursor: pointer;
    }    
</style>
<script>
$(document).ready(function() {
    var message = <?= json_encode($_SESSION["success"] ?? ''); ?>;
    
    if (message) {
        $("#paymentSuccessModal .modal-body").html(message);
        $("#paymentSuccessModal").modal("show");

        setTimeout(function() {
            $("#paymentSuccessModal").modal("hide");
            setTimeout(function() {
                window.location.href = "<?= base_url('elite/auth/login'); ?>";
            }, 500);
        }, 3000);
    }
});
</script>