<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variabel untuk menyimpan data konfigurasi dari API
        let config = {
            minCapital: 0,
            additionalStep: 0,
            percentageFee: 0,
            membershipDays: 0
        };

        let additionalCapital = 0;

        const decreaseBtn = document.getElementById('decrease');
        const increaseBtn = document.getElementById('increase');
        const additionalCapitalInput = document.getElementById('additional-capital');
        const totalCapitalDisplay = document.getElementById('total-capital-display');
        const paymentAmountInput = document.getElementById('payment-amount');
        const minCapitalValue = document.querySelector('.min-capital-value');
        const membershipDaysElement = document.querySelector('.membership-days');

        // Elemen tambahan untuk menampilkan nilai dinamis
        const additionalStepDisplay = document.getElementById('additional-step-display');
        const percentageFeeDisplay = document.getElementById('percentage-fee-display');
        const membershipDaysDisplay = document.getElementById('membership-days-display');
        const membershipDaysDisplay2 = document.getElementById('membership-days-display2');
        let totalCapital;

        // Format currency function
        function formatCurrency(amount, currency = '$') {
            return `${currency} ${amount.toLocaleString('en-US')}`;
        }

        // Format percentage function
        function formatPercentage(value) {
            return `${(value * 100).toFixed(2)}%`;
        }

        // Parse currency string to number
        function parseCurrency(currencyString) {
            return parseFloat(currencyString.replace(/[^\d.-]/g, ''));
        }

        // Update displays
        function updateDisplays() {
            additionalCapitalInput.value = formatCurrency(additionalCapital);

            totalCapital = config.minCapital + additionalCapital;
            totalCapitalDisplay.textContent = formatCurrency(totalCapital);

            // Debug untuk melihat nilai yang digunakan dalam perhitungan
            console.log('Total Capital:', totalCapital);
            console.log('Percentage Fee:', config.percentageFee);

            // Perhitungan payment amount: total capital * percentageMultiplier * percentageFee, dikonversi ke Euro
            const paymentAmountUSD = totalCapital * config.percentageFee;
            const paymentAmountEuro = paymentAmountUSD;

            console.log('Payment Amount USD:', paymentAmountUSD);
            console.log('Payment Amount Euro:', paymentAmountEuro);

            paymentAmountInput.value = `€ ${paymentAmountEuro}`;
        }

        // Decrease button click
        decreaseBtn.addEventListener('click', function() {
            if (additionalCapital >= config.additionalStep) {
                additionalCapital -= config.additionalStep;
                updateDisplays();
            }
        });

        // Increase button click
        increaseBtn.addEventListener('click', function() {
            additionalCapital += config.additionalStep;
            updateDisplays();
        });

        // Confirm payment function
        window.confirmPayment = function() {
            const totalCapital = config.minCapital + additionalCapital;
            const paymentAmountWithSymbol = paymentAmountInput.value;
            // Pastikan nilai yang dikirim adalah numerik murni
            const paymentAmount = parseFloat(paymentAmountWithSymbol.replace(/[^\d.-]/g, ''));

            // Validasi nilai
            if (isNaN(paymentAmount) || paymentAmount <= 0) {
                alert('Invalid payment amount. Please try again.');
                return;
            }

            // Konfirmasi dari user
            if (!confirm(`You will confirm the investment of ${formatCurrency(totalCapital)} with a payment of € ${paymentAmount}. Continue?`)) {
                return;
            }

            console.log('Sending payment amount:', paymentAmount, 'type:', typeof paymentAmount);

            // Siapkan data untuk dikirim ke server
            const formData = new FormData();
            formData.append('amount', paymentAmount);
            formData.append('totalcapital', totalCapital);

            // Tampilkan loading
            const confirmButton = document.querySelector('.confirm-button');
            const originalText = confirmButton.textContent;
            confirmButton.textContent = 'Processing...';
            confirmButton.disabled = true;

            // Kirim data ke server untuk disimpan dalam session
            fetch('/homepage/save_payment_to_session', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        // Redirect ke halaman payment option
                        window.location.href = '/homepage/payment_option';
                    } else {
                        alert('An error occurred: ' + data.message);
                        confirmButton.textContent = originalText;
                        confirmButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error saving payment data:', error);
                    alert('An error occurred while saving payment data. Please try again.');
                    confirmButton.textContent = originalText;
                    confirmButton.disabled = false;
                });
        };

        // Fungsi untuk mengambil data konfigurasi dari API
        function fetchInvestmentConfig() {
            fetch('/homepage/get_investment_config')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data dari API:', data);

                    // Simpan data konfigurasi dengan memastikan tipe data yang benar
                    config.minCapital = parseFloat(data.min_capital);
                    config.additionalStep = parseFloat(data.additional_step);
                    config.percentageFee = parseFloat(data.percentage_fee);
                    config.membershipDays = parseInt(data.membership_days);

                    console.log('Config setelah parsing:', config);

                    // Update tampilan dengan data dari API
                    minCapitalValue.textContent = formatCurrency(config.minCapital);
                    additionalStepDisplay.textContent = formatCurrency(config.additionalStep);
                    percentageFeeDisplay.textContent = formatPercentage(config.percentageFee);
                    membershipDaysElement.textContent = `${config.membershipDays} Days Membership`;
                    membershipDaysDisplay.textContent = config.membershipDays;
                    membershipDaysDisplay2.textContent = config.membershipDays;

                    // Initialize displays
                    updateDisplays();
                })
                .catch(error => {
                    console.error('Error fetching investment config:', error);
                    alert('An error occurred while fetching investment config. Please refresh the page.');
                });
        }

        // Panggil fungsi untuk mengambil data konfigurasi saat halaman dimuat
        fetchInvestmentConfig();
    });
</script>