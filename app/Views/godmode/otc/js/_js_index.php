<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountBtcInput = document.getElementById('amountBtc');
        const buyPriceInput = document.getElementById('buyPrice');
        const sellPriceInput = document.getElementById('sellPrice');
        const calculateBtn = document.getElementById('calculateBtn');
        const resultContainer = document.getElementById('result-container');

        const resultAmountBuyUsdtInput = document.getElementById('resultAmountBuyUSDT');
        const resultAmountSellUsdtInput = document.getElementById('resultAmountsellUSDT');
        const profitInput = document.getElementById('profit');

        function calculateProfit() {
            const amountBtc = parseFloat(amountBtcInput.value) || 0;
            const buyPrice = parseFloat(buyPriceInput.value) || 0;
            const sellPrice = parseFloat(sellPriceInput.value) || 0;

            // Perhitungan sesuai dengan rumus yang Anda berikan
            const amountBuyUsdt = amountBtc * buyPrice;
            const amountSellUsdt = amountBtc * sellPrice;
            const profit = amountSellUsdt - amountBuyUsdt;

            // Menampilkan hasil di input
            resultAmountBuyUsdtInput.value = amountBuyUsdt.toFixed(2);
            resultAmountSellUsdtInput.value = amountSellUsdt.toFixed(2);
            profitInput.value = profit.toFixed(2);

            // Menampilkan container hasil perhitungan
            resultContainer.style.display = 'block';
        }

        calculateBtn.addEventListener('click', calculateProfit);
    });
</script>