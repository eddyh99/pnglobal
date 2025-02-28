<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        // Tampilkan notifikasi kecil
        var tooltip = document.createElement("div");
        tooltip.innerHTML = "Copied!";
        tooltip.style.position = "fixed";
        tooltip.style.backgroundColor = "#b48b3d";
        tooltip.style.color = "#000";
        tooltip.style.padding = "5px 10px";
        tooltip.style.borderRadius = "5px";
        tooltip.style.top = "20px";
        tooltip.style.right = "20px";
        tooltip.style.zIndex = "9999";
        document.body.appendChild(tooltip);

        // Hilangkan notifikasi setelah 2 detik
        setTimeout(function() {
            tooltip.style.opacity = "0";
            tooltip.style.transition = "opacity 0.5s";
            setTimeout(function() {
                document.body.removeChild(tooltip);
            }, 500);
        }, 2000);
    }
</script>