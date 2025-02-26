<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        // Show tooltip or notification
        var tooltip = document.createElement("div");
        tooltip.className = "copy-tooltip";
        tooltip.innerHTML = "Copied!";
        document.body.appendChild(tooltip);

        // Position the tooltip near the button
        var button = copyText.nextElementSibling;
        var rect = button.getBoundingClientRect();
        tooltip.style.top = (rect.top - 40) + "px";
        tooltip.style.left = (rect.left - 20) + "px";

        // Remove the tooltip after 2 seconds
        setTimeout(function() {
            tooltip.style.opacity = "0";
            setTimeout(function() {
                document.body.removeChild(tooltip);
            }, 500);
        }, 1500);
    }
</script>