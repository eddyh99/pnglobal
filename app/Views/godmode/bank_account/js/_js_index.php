<script>
    document.addEventListener("DOMContentLoaded", function() {
        const apiUrl = "<?= BASE_URL ?>/godmode/bank_account/get_bank_account";

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const formDiv = document.getElementById("bankAccountForm");
                const viewDiv = document.getElementById("bankAccountView");

                if (data.result && data.result.success && data.result.data) {
                    // Data ada, tampilkan view
                    const bankData = data.result.data;
                    document.getElementById("viewName").textContent = bankData.bank_account_name || "-";
                    document.getElementById("viewType").textContent = bankData.bank_account_type || "-";
                    document.getElementById("viewRouting").textContent = bankData.bank_routing_number || "-";
                    document.getElementById("viewNumber").textContent = bankData.bank_account_number || "-";

                    formDiv.remove();
                    viewDiv.style.display = "block";
                } else {

                    viewDiv.remove();
                    viewDiv.style.display = "none";
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    });
</script>