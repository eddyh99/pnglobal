<style>
    /* Modal overlay */
    #walletModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Modal content */
    #walletModal>div {
        background: #fff;
        padding: 2rem;
        border-radius: 0.5rem;
        width: 90%;
        /* Jangan gunakan 100% agar ada margin */
        max-width: 400px;
        /* Maksimal lebar modal */
        box-sizing: border-box;
        /* Pastikan padding tidak menambah width */
        text-align: center;
        position: relative;
        word-break: break-word;
        /* Agar teks panjang seperti wallet tidak melebar */
    }


    .invoice-table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-table th,
    .invoice-table td {
        border: 1px solid #ccc;
        padding: 0.6rem 0.8rem;
        text-align: left;
        vertical-align: middle;
    }

    .invoice-table th {
        width: 25%;
        background: #f9f9f9;
        font-weight: 600;
    }

    .copy-field {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .copy-field .label-colon {
        margin-right: 0.3rem;
        font-weight: 600;
    }

    .copy-field input {
        flex: 1;
        min-width: 120px;
        padding: 0.4rem 0.6rem;
        border: 1px solid #ccc;
        border-radius: 0.3rem;
        background: #fdfdfd;
        font-size: 0.9rem;
    }

    .button-copy {
        padding: 0.35rem 0.75rem;
        border: none;
        border-radius: 0.3rem;
        background: #bfa573;
        color: #fff;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .button-copy:hover {
        background: #9e8a5e;
    }
</style>
<script>
    // copy to clipboard
    function copyToClipboard(elementId) {
        const input = document.getElementById(elementId);
        let value = input.value.replace(/^\$/, '').trim(); // Hapus $ di depan

        navigator.clipboard.writeText(value)
            .then(() => showCopyAlert("Copied: " + value))
            .catch(err => console.error("Copy failed", err));
    }

    // alert copy
    function showCopyAlert(message) {
        let alertBox = document.createElement("div");
        alertBox.className = "alert alert-success fade show position-absolute";
        alertBox.style = "top: 1rem; right: 1rem; width: 30%; z-index: 99999;";
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
</script>

<script>
    function closeModal() {
        document.getElementById('walletModal').style.display = 'none';
    }

    function checkWallet() {
        const address = document.getElementById('addressWallet').value.trim();
        const coint_network = "<?= $coint_network ?>";
        const network = "<?= $network ?>";
        const token = "<?= $token ?>";
        const wallet_db_balance = parseFloat("<?= $wallet_db_balance ?>");

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
                const payAmount = Math.round(parseFloat("<?= $payamount ?>"));
                const expectedBalanceAfterDeposit = wallet_db_balance + payAmount;
                const balance = data.balance;
                // const balance = expectedBalanceAfterDeposit; // UNTUK TESTING, ANGGAP SALDO SUDAH MASUK
                let title = "";
                let message = "";
                // console.log("Required Amount:", payAmount);
                // console.log("Wallet DB Balance:", wallet_db_balance);
                // console.log("Expected Balance After Deposit:", expectedBalanceAfterDeposit);
                // console.log("Real Wallet Balance:", balance);
                // console.log("Token:", token);
                // console.log("Network:", network);
                // console.log("Coint_Network:", coint_network);

                if (data.status === "success") {
                    // ==========================================
                    // Cek apakah saldo sudah sesuai
                    // Note : Cek Balance Wallet Real >= expectedBalanceAfterDeposit (Ekspektasi saldo setelah deposit)
                    // ==========================================
                    if (balance >= expectedBalanceAfterDeposit) {
                        title = "Transaction Successful";
                        message = `Wallet: ${data.wallet_address} <br> Token: ${data.token} <br> Balance: ${data.balance}`;

                        // Kirim order_id ke server
                        fetch('<?= BASE_URL ?>/hedgefund/auth/deposit_payment_crypto_update', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    invoice: "<?= $order_id ?>",
                                    wallet_balance: balance,
                                    token: token,
                                    wallet_address: address,
                                })
                            })
                            .then(response => response.json())
                            .then(result => {
                                console.log('Update successful:', result);
                                setTimeout(() => {
                                    window.location.href = "<?= BASE_URL ?>hedgefund/auth/login";
                                }, 5000);
                            })
                            .catch(error => {
                                console.error('Error updating payment:', error);
                            });
                    } else {
                        title = "Balance Not Sent Yet";
                        message = `Wallet: ${data.wallet_address} <br> Token: ${data.token} <br> Balance: ${data.balance}`;
                    }
                } else {
                    title = "Error";
                    message = "An error occurred while checking the wallet.";
                }


                document.getElementById('modalTitle').innerHTML = title;
                document.getElementById('modalMessage').innerHTML = message;
                document.getElementById('walletModal').style.display = 'flex';
            })
            .catch(err => {
                alert("Gagal memeriksa wallet: " + err);
                console.error(err);
            });
    }
</script>