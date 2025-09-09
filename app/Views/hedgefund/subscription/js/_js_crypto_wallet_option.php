<style>
    .custom-modal-bg {
        background-color: #bda069 !important;
        color: #fff;
        border-radius: 10px;
    }

    .custom-modal-bg .modal-header {
        border-bottom: none;
    }

    .custom-modal-bg .modal-footer {
        border-top: none;
    }

    .custom-modal-size {
        max-height: 400px;
        /* Adjust this to make it bigger */
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ganti dengan email user dari view
        const email = "<?= $email ?>";

        // Endpoint untuk cek wallet
        const checkWalletUrl = `<?= BASE_URL ?>hedgefund/auth/check_wallet_hedgefund`;
        const createWalletUrl = `<?= BASE_URL ?>hedgefund/auth/create_wallet_hedgefund`;

        // Data yang dikirim
        const payload = {
            email: email
        };

        fetch(checkWalletUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.code === 200 && data.message && data.message.length > 0) {
                    console.log("Wallet Already exists");
                } else {
                    console.log("Wallet belum ada, membuat wallet...");

                    // fetch create wallet
                    fetch(createWalletUrl, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(resp => resp.json())
                        .then(createData => {
                            if (createData.code === 201) {
                                console.log(createData.message);
                            } else {
                                console.error("Gagal membuat wallet:", createData);
                            }
                        })
                        .catch(err => console.error("Error create wallet:", err));
                }
            })
            .catch(err => console.error("Error check wallet:", err));

    });
</script>