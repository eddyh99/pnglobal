<script>
$(document).ready(function() {
    $('#from').on('change', function() {
        const isCommission = this.value === 'commission';
        
        $('#amount').val('')
            .attr('placeholder', isCommission ? 'Full of balance' : 'Enter amount')
            .prop('readonly', isCommission);
        
        $('#to').val(isCommission ? 'fund' : $('#to').val());
        $('#to option[value="trade"]').prop('disabled', isCommission);
    });
});
</script>