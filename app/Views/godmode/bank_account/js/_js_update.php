<script>
    document.addEventListener("DOMContentLoaded", function() {
        const apiUrl = "<?= BASE_URL ?>/godmode/bank_account/get_bank_account";

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log("API Response:", data);

                if (data.result && data.result.success && data.result.data) {
                    const bankData = data.result.data;

                    // Isi input text
                    document.querySelector('input[name="bank_account_name"]').value = bankData.bank_account_name || "";
                    document.querySelector('input[name="bank_routing_number"]').value = bankData.bank_routing_number || "";
                    document.querySelector('input[name="bank_account_number"]').value = bankData.bank_account_number || "";

                    // Set radio account type
                    if (bankData.bank_account_type) {
                        const radio = document.querySelector(`input[name="bank_account_type"][value="${bankData.bank_account_type}"]`);
                        if (radio) {
                            radio.checked = true;
                        }
                    }
                } else {
                    console.warn("Tidak ada data bank account.");
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    });
</script>