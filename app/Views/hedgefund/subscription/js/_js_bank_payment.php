<style>
    tr {
        height: 60px;
    }

    .th-deposit {
        color: white;
        /* putih dengan opacity 90% */
        text-align: left;
        padding: 4px;
        width: 25%;
    }

    .td-normal {
        padding: 4px;
        color: white;
        text-align: left;
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

    .outer-border-wrapper {
        border: 2px solid #bfa573;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .border-wrapper {
        border: 1px solid #bfa573;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
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
        alertBox.className = "alert alert-success fade show position-absolute d-flex align-items-center justify-content-between";
        alertBox.style = "top: 1rem; right: 1rem; width: 30%; z-index: 99999;";
        alertBox.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="iq-alert-icon me-2"><i class="ri-information-line"></i></div>
                <div class="iq-alert-text text-black">${message}</div>
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()" aria-label="Close"></button>
        `;
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

</script>