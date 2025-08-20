<style>
    .locked-input {
        color: gray !important;
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountBtcInput = document.getElementById('amount_btc');
        const buyPriceInput = document.getElementById('buy_price');
        const sellPriceInput = document.getElementById('sell_price');
        const calculateBtn = document.getElementById('calculateBtn');
        const resultContainer = document.getElementById('result-container');
        const form = document.querySelector('form');

        const userRole = "<?= $role ?>";
        const BASE_SAVE = "<?= base_url('godmode/otc/save') ?>";
        const BASE_CREATE = "<?= base_url('godmode/otc/create') ?>";
        const BASE_HISTORY = "<?= base_url('godmode/otc/history') ?>";

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

        // 🔹 Load history data
        fetch(BASE_HISTORY)
            .then(res => res.json())
            .then(resp => {
                if (resp.status === 200 && resp.result && resp.result.data) {
                    const d = resp.result.data;

                    // Kalau ada data → SAVE
                    form.action = BASE_SAVE;
                    calculateBtn.textContent = "Update Calculate";

                    // tambahkan input hidden id jika belum ada
                    let hiddenId = document.getElementById('otc_id');
                    if (!hiddenId) {
                        hiddenId = document.createElement('input');
                        hiddenId.type = "hidden";
                        hiddenId.name = "id";
                        hiddenId.id = "otc_id";
                        form.appendChild(hiddenId);
                    }
                    hiddenId.value = d.id;

                    // Prefill form
                    amountBtcInput.value = d.amount_btc ?? '';
                    buyPriceInput.value = d.buy_price ?? '';
                    sellPriceInput.value = d.sell_price ?? '';

                    if (userRole != 'superadmin') {
                        const lockAmountBtcInput = document.querySelector('input[name="lock_amount_btc"]');
                        if (lockAmountBtcInput) {
                            if (d.lock_amount_btc === "1") {
                                lockAmountBtcInput.remove();
                                amountBtcInput.disabled = true;
                                amountBtcInput.classList.add('locked-input');
                            } else {
                                lockAmountBtcInput.parentElement.remove();
                            }
                        }

                        const lockBuyPriceInput = document.querySelector('input[name="lock_buy_price"]');
                        if (lockBuyPriceInput) {
                            if (d.lock_buy_price === "1") {
                                lockBuyPriceInput.remove();
                                buyPriceInput.disabled = true; // ✅ perbaikan
                                buyPriceInput.classList.add('locked-input');
                            } else {
                                lockBuyPriceInput.parentElement.remove();
                            }
                        }

                        const lockSellPriceInput = document.querySelector('input[name="lock_sell_price"]');
                        if (lockSellPriceInput) {
                            if (d.lock_sell_price === "1") {
                                lockSellPriceInput.remove();
                                sellPriceInput.disabled = true; // ✅ perbaikan
                                sellPriceInput.classList.add('locked-input');
                            } else {
                                lockSellPriceInput.parentElement.remove();
                            }
                        }
                    }


                    // isi chckbox jika rolenya superadmin
                    if (userRole === 'superadmin') {
                        document.querySelector('[name="lock_amount_btc"]').checked = d.lock_amount_btc === "1";
                        document.querySelector('[name="lock_buy_price"]').checked = d.lock_buy_price === "1";
                        document.querySelector('[name="lock_sell_price"]').checked = d.lock_sell_price === "1";
                    }
                    calculateProfit()
                } else {
                    // Kalau tidak ada data → CREATE
                    form.action = BASE_CREATE;
                }
            })
            .catch(err => {
                console.error('Error fetching history:', err);
                form.action = BASE_CREATE; // fallback
            });

        // Pastikan checkbox unchecked tetap kirim value "0"
        form.addEventListener('submit', function() {
            const checkboxes = this.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                if (!cb.checked) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = cb.name;
                    hidden.value = '0';
                    this.appendChild(hidden);
                }
            });
        });

    });
</script>