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


        // =========== TESTING =============
        // BEP20 USDT & USDC
        // const address = "0x98B4be9C7a32A5d3bEFb08bB98d65E6D204f7E98"; // ada usdtnya bep20
        // const address = "0x11a0c9270D88C99e221360BCA50c2f6Fda44A980"; // ada usdcnya bep20

        // POLYGON USDT & USDC
        // const address = "0x8d038098fBA26a55Dd9b4eeBAe642480A52eeED8"; // ada usdt polygon
        // const address = "0x937Fe3Ff2A9B7C24F4a340E287Ed94957424f735"; // ada usdc polygon

        // ERC20 USDC & USDT
        // const address = "0xe3D41d19564922C9952f692C5Dd0563030f5f2EF"; // ada usdc & Usdt erc20

        // TRC20 USDT
        // const address = "TCjVk9L3LJLC5UiUawXfHa3USTUY7syEFL"; // ada usdt trc20

        // BASE USDC
        // const address = "0x61edFCbdfc36ae06CaCF36e8cC824a2aDEaBffff"; // ada usdc base

        // SOLANA USDC
        // const address = "53bmyryLj1RGjYWHVXcSz96RK3d8XCGV5bCEpCh5J6u3"; // ada usdc solana


        const coint_network = "<?= $coint_network ?>";

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

                if (data.status === "success") {
                    if (parseFloat(data.balance) === 0) {
                        title = "Balance Not Sent Yet";
                        message = `Wallet: ${data.wallet_address} <br> Token: ${data.token} <br> Balance: ${data.balance}`;
                    } else {
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
                                    invoice: "<?= $order_id ?>" // hanya mengirim order_id
                                })
                            })
                            .then(response => response.json())
                            .then(result => {
                                console.log('Update successful:', result);
                            })
                            .catch(error => {
                                console.error('Error updating payment:', error);
                            });
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