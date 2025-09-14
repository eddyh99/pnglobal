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
        const invoice = "<?= $order_id ?>";

        // =========== TESTING EXAMPLES =============
        // Uncomment untuk testing dengan wallet yang berisi saldo
        // const address = "0x98B4be9C7a32A5d3bEFb08bB98d65E6D204f7E98"; // BEP20 USDT
        // const address = "0x11a0c9270D88C99e221360BCA50c2f6Fda44A980"; // BEP20 USDC
        // const address = "0x8d038098fBA26a55Dd9b4eeBAe642480A52eeED8"; // POLYGON USDT
        // const address = "0x937Fe3Ff2A9B7C24F4a340E287Ed94957424f735"; // POLYGON USDC
        // const address = "0xe3D41d19564922C9952f692C5Dd0563030f5f2EF"; // ERC20 USDC & USDT
        // const address = "TCjVk9L3LJLC5UiUawXfHa3USTUY7syEFL"; // TRC20 USDT
        // const address = "0x61edFCbdfc36ae06CaCF36e8cC824a2aDEaBffff"; // BASE USDC
        // const address = "53bmyryLj1RGjYWHVXcSz96RK3d8XCGV5bCEpCh5J6u3"; // SOLANA USDC

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
                if (data.status === "success") {
                    console.log("Wallet Data:", data.balance);
                    if (balance >= payamount) {
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
                                    invoice: invoice
                                })
                            })
                            .then(resp => resp.json())
                            .then(result => {
                                if (result.code === 201) {
                                    console.log("Success Update Payment");
                                    setTimeout(() => {
                                        window.location.href = "<?= BASE_URL ?>hedgefund/dashboard";
                                    }, 5000);
                                }
                                if (result.code === 400) {
                                    console.log("Payment already confirmed");
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