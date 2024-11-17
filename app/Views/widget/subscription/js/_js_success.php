<script>
    function postMessage(){
        Total.postMessage('success');
    }
    postMessage();
    function sendStatus() {
        var value = {"status":"success"}
        window.chrome.webview.postMessage(value);
    }
    sendStatus();
</script>