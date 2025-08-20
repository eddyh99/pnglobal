
<style>
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