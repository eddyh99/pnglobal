<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minCapital = 8000;
        const additionalStep = 2000;
        const percentageMultiplier = 0.7; // 70% dari total capital
        const percentageFee = 0.11; // 11% untuk membership fee
        const euroConversionRate = 0.844; // Kurs USD ke Euro yang disesuaikan

        let additionalCapital = 0;

        const decreaseBtn = document.getElementById('decrease');
        const increaseBtn = document.getElementById('increase');
        const additionalCapitalInput = document.getElementById('additional-capital');
        const totalCapitalDisplay = document.getElementById('total-capital-display');
        const paymentAmountInput = document.getElementById('payment-amount');

        // Format currency function
        function formatCurrency(amount, currency = '$') {
            return `${currency} ${amount.toLocaleString('en-US')}`;
        }

        // Update displays
        function updateDisplays() {
            additionalCapitalInput.value = formatCurrency(additionalCapital);

            const totalCapital = minCapital + additionalCapital;
            totalCapitalDisplay.textContent = formatCurrency(totalCapital);

            // Perhitungan payment amount: total capital * 0.7 * 0.11, dikonversi ke Euro
            const calculationBase = totalCapital * percentageMultiplier;
            const paymentAmountUSD = calculationBase * percentageFee;
            const paymentAmountEuro = Math.round(paymentAmountUSD * euroConversionRate);

            paymentAmountInput.value = `€ ${paymentAmountEuro}`;
        }

        // Decrease button click
        decreaseBtn.addEventListener('click', function() {
            if (additionalCapital >= additionalStep) {
                additionalCapital -= additionalStep;
                updateDisplays();
            }
        });

        // Increase button click
        increaseBtn.addEventListener('click', function() {
            additionalCapital += additionalStep;
            updateDisplays();
        });

        // Initialize displays
        updateDisplays();

        // Confirm payment function
        window.confirmPayment = function() {
            const totalCapital = minCapital + additionalCapital;
            alert(`Anda akan mengkonfirmasi investasi sebesar ${formatCurrency(totalCapital)} dengan pembayaran ${paymentAmountInput.value}`);
            // Tambahkan kode untuk mengirim data ke server di sini
        };
    });
</script>