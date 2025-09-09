<style>
    /* For Chrome, Safari, Edge, Opera */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    
    /* For Firefox */
    .no-spinner {
      -moz-appearance: textfield;
    }
</style>
<script>
    let balance = parseFloat("<?= floor($balance['fund']->usdt * 100) / 100 ?? 0 ?>") || 0;

    $("#maxbalance").on("click", function () {
        $("#amount").val(balance);
    });

    
</script>