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


    .qr-code-container {
        position: fixed;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        width: 200px;
        left: 52.5% !important;
        /* Override posisi left yang diberikan melalui JavaScript */
        transform: translateX(-50%);
        /* Memastikan QR code berada di tengah */
    }

    .qr-code-container button {
        background-color: #B48B3D;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Container untuk referral link dan QR code */
    .referral-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .referral-link-container {
        width: 50%;
    }

    .qr-code-section {
        width: 50%;
        text-align: right;
    }
    
    .label-destination{
        min-width: 100px; 
        height: 45px; 
        border: 1px solid #b48b3d; 
        background-color: #1c1c1c;
    }
    
    .balance-box{
        border: 1px solid #b48b3d; 
        border-radius: 6px; 
        min-width: 180px;
    }
</style>
<script>
    const type = <?= json_encode($type); ?>;
    let balanceUSDT = parseFloat("<?= $balance[$type == 'commission_trade' ? 'commission' : $type]->usdt ?? 0 ?>") || 0;
    let balanceBTC = parseFloat("<?= $balance[$type]->btc ?? 0 ?>") || 0;
    // let balanceCommission = parseFloat("<?= $balance['commission']->usdt ?? 0 ?>") || 0;
    
    // Update #pairusdt text based on selected coin
    function updatePairText() {
        const selectedCoin = $('#coin').val().toUpperCase();
        $('#pairusdt').text(selectedCoin);
    }
    
    // Handle MAX button click
    $("#maxbalance").on("click", function () {
        const selectedCoin = $('#coin').val();
    
        let balance = 0;
        if (selectedCoin === 'usdt') {
            balance = balanceUSDT;
        } else if (selectedCoin === 'btc') {
            balance = balanceBTC;
        }
    
        if (balance === 0) {
            alert("Your balance is zero.");
            return;
        }
    
        // Format BTC with 6 decimals
        const formatted = selectedCoin === 'btc'
            ? balance.toFixed(6)
            : balance;
    
        $("#amount").val(formatted);
    });

    
    // Handle coin change
    $('#coin').on('change', function () {
        const selectedCoin = $(this).val();

        let balance = 0;
        let formatted = '';
    
        if (selectedCoin === 'usdt') {
            $('#coin-type').val("usdt");
            balance = balanceUSDT;
            formatted = Number(balance).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 2 }) + ' USDT';
            $("#amount").val('');
        } else if (selectedCoin === 'btc') {
            $('#coin-type').val("btc");
            balance = balanceBTC;
            formatted = Number(balance).toFixed(6) + ' BTC';
            $("#amount").val('');
        }
    
        $("#textbalance").text(formatted);
        updatePairText();
    });
    
    // Handle 'from' change and coin UI logic
    $('#from').on('change', function () { 
        const fromVal = this.value;
        const isCommission = fromVal === 'commission';
    
        // Update amount input
        // $('#amount')
        //     .val('')
        //     .attr('placeholder', isCommission ? 'Entire balance' : 'Enter amount')
        //     .prop('readonly', isCommission);
    
        // Adjust 'to' value and disable options accordingly
        if (isCommission) {
            $('#to').val('fund');
            $('#availablebalance').css('visibility', 'hidden');
            $("#maxbalance").hide();
        } else {
            $('#availablebalance').css('visibility', 'visible');
            $("#maxbalance").show();

    
            if (fromVal === 'fund') {
                $('#to').val('trade');
            } else if (fromVal === 'trade') {
                $('#to').val('fund');
            }
        }
    
        // Coin selection logic (disable or enable)
        if (fromVal === 'fund' || fromVal === 'commission') {
            $('#coin').val('usdt').prop('disabled', true);
        } else if (fromVal === 'trade') {
            $('#coin').prop('disabled', false);
        }
    
        updatePairText(); // update pair text in all cases
    });
    
    // Initial call on page load to sync UI
    updatePairText();

</script>