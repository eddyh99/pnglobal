<style>
    .th-deposit {
        text-align: left;
        padding: 4px;
        width: 25%;
        color: white;
    }

    .td-normal {
        padding: 4px;
        color: white;
    }

    .td-input {
        padding: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .button-copy {
        margin-left: 4px;
        padding: 4px 8px;
        border: none;
        background-color: #bfa573;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<script>
    // Copy wallet address
    function copyWalletAddress() {
        const input = document.getElementById('addressWallet');
        if (!input.value) {
            showCopyAlert("No wallet address to copy!");
            return;
        }
        navigator.clipboard.writeText(input.value)
            .then(() => showCopyAlert("Wallet address copied successfully!"))
            .catch(err => console.error("Failed to copy wallet address:", err));
    }

    // Copy total payment
    function copyToClipboard(elementId) {
        const input = document.getElementById(elementId);
        if (!input.value) {
            showCopyAlert("No value to copy!");
            return;
        }
        // Remove all non-numeric characters (only digits and dot)
        let value = input.value.replace(/[^0-9.]/g, '');
        navigator.clipboard.writeText(value)
            .then(() => showCopyAlert("Total payment copied: " + value))
            .catch(err => console.error("Failed to copy total payment:", err));
    }

    // Allert box for copy confirmation
    function showCopyAlert(message) {
        let alertBox = document.createElement("div");
        alertBox.className = "alert alert-success fade show";
        // Change from absolute to fixed
        alertBox.style = "position: fixed; top: 1rem; right: 1rem; width: 30%; z-index: 99999;";
        alertBox.innerHTML = `
        <div class="iq-alert-icon"><i class="ri-information-line"></i></div>
        <div class="iq-alert-text text-black">${message}</div>
        <button type="button" class="close" onclick="this.parentElement.remove()">
            <i class="ri-close-line text-black"></i>
        </button>
        `;
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

    // Close modal
    function closeModal() {
        document.getElementById('walletModal').style.display = 'none';
    }

    // Check wallet balance
    function checkWallet() {
        // Ambil alamat wallet dari input baru
        const address = document.getElementById('addressWallet').value.trim();
        const coint_network = "<?= $coint_network ?>";
        const token = "<?= $token ?>";
        const network = "<?= $network ?>";
        const invoice = "<?= $order_id ?>";
        const balance_db = parseFloat("<?= $wallet_db_balance ?>");

        // Panggil API untuk cek saldo wallet
        fetch('<?= BASE_URL ?>/hedgefund/auth/check_wallet_balance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    wallet_address: address,
                    token: coint_network
                })
            })
            .then(response => response.json())
            .then(data => {
                let title = "";
                let message = "";
                const payamount = Math.round(parseFloat("<?= $total_payamount ?>") * 100);
                const balance = Math.round(parseFloat(data.balance) * 100);
                const expectedBalanceAfterDeposit = balance_db + (payamount / 100);

                // ==========================================
                // Testing Data
                // const balance = expectedBalanceAfterDeposit; // Simulasi saldo yang diterima lebih besar dari expected
                // ==========================================

                console.log("Balance from DB:", balance_db);
                console.log("Payamount:", payamount / 100);
                console.log("Expected Balance After Deposit:", expectedBalanceAfterDeposit);
                console.log("Current Balance Real Wallet:", balance);
                if (data.status === "success") {
                    // ==========================================
                    // Cek apakah saldo sudah sesuai
                    // Note : Cek Balance Wallet Real >= expectedBalanceAfterDeposit (Ekspektasi saldo setelah deposit)
                    // ==========================================
                    if (balance >= expectedBalanceAfterDeposit) {
                        title = "Transaction Successful";
                        message = `Wallet: ${data.wallet_address} <br> : ${data.token}`;

                        // Kirim order_id ke server untuk update
                        fetch('<?= BASE_URL ?>/hedgefund/auth/deposit_payment_crypto_update', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    invoice: invoice,
                                    payamount: payamount / 100,
                                    network: network,
                                    token: token,
                                    wallet_address: address
                                })
                            })
                            .then(resp => resp.json())
                            .then(result => {
                                console.log("Update Payment Response:", result);
                                if (result.code === 201) {
                                    console.log("Success Update Payment");
                                    setTimeout(() => {
                                        window.location.href = "<?= BASE_URL ?>hedgefund/dashboard";
                                    }, 5000);
                                }
                                if (result.code === 400) {
                                    console.log("Payment already confirmed");
                                    setTimeout(() => {
                                        window.location.href = "<?= BASE_URL ?>hedgefund/dashboard";
                                    }, 5000);
                                }
                            })
                            .catch(err => console.error('Error updating payment:', err));
                    } else {
                        title = "Balance Not Sent Yet";
                        message = `Wallet: ${data.wallet_address} <br> Token: ${data.token}`;
                    }
                } else {
                    title = "Error";
                    message = "An error occurred while checking the wallet.";
                }

                // Tampilkan modal
                document.getElementById('modalTitle').innerHTML = title;
                document.getElementById('modalMessage').innerHTML = message;
                document.getElementById('walletModal').style.display = 'flex';
            })
            .catch(err => {
                alert("Failed to check wallet: " + err);
                console.error(err);
            });
    }
</script>