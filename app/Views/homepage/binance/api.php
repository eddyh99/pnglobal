<section class="tutorial-page">
    <div class="tutorial-container">
        <h1 class="api-title">BINANCE API CONNECTION</h1>

        <div class="binance-fullcard">
            <div class="binance-fullcard-header">
                Connect Binance API
            </div>
            <form id="binance-api-form" method="post">
                <div class="binance-detailcard">
                    <div class="label">
                        API Key
                    </div>
                    <div class="value">
                        <input type="text" name="api_key" id="api_key" value="">
                    </div>
                    <div class="label">
                        API Secret
                    </div>
                    <div class="value">
                        <input type="text" name="api_secret" id="api_secret" value="">
                    </div>
                </div>
                <div class="binance-fullcard-footer">
                    <button type="submit" class="save-btn" id="save-btn">SAVE</button>
                </div>
            </form>
        </div>

        <div class="binance-button-row">
            <a href="/homepage/tutorial" target="_blank" class="get-api-btn">How to get API?</a>
            <a href="/homepage/contactform?service=SG9tZXBhZ2UgLSBQTiBHbG9iYWw="  target="_blank" class="support-btn">Contact Support</a>
        </div>

        <!-- Alert messages -->
        <div id="alert-success" class="alert alert-success" style="display: none; margin-top: 20px;"></div>
        <div id="alert-error" class="alert alert-danger" style="display: none; margin-top: 20px;"></div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submit handler
        document.getElementById('binance-api-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable submit button to prevent multiple submissions
            const saveBtn = document.getElementById('save-btn');
            saveBtn.disabled = true;
            saveBtn.innerHTML = 'Processing...';

            // Hide any existing alerts
            document.getElementById('alert-success').style.display = 'none';
            document.getElementById('alert-error').style.display = 'none';

            // Get form data
            const apiKey = document.getElementById('api_key').value;
            const apiSecret = document.getElementById('api_secret').value;

            // Validate form data
            if (!apiKey || !apiSecret) {
                document.getElementById('alert-error').innerHTML = 'API Key and API Secret are required';
                document.getElementById('alert-error').style.display = 'block';
                saveBtn.disabled = false;
                saveBtn.innerHTML = 'SAVE';
                return;
            }

            // Create form data object
            const formData = new FormData();
            formData.append('api_key', apiKey);
            formData.append('api_secret', apiSecret);

            // Send AJAX request
            fetch('<?= BASE_URL ?>homepage/save_binance_api', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        document.getElementById('alert-success').innerHTML = data.message;
                        document.getElementById('alert-success').style.display = 'block';

                        // Redirect after success
                        setTimeout(function() {
                            window.location.href = '<?= BASE_URL ?>member/auth/login';
                        }, 2000);
                    } else {
                        // Show error message
                        document.getElementById('alert-error').innerHTML = data.message;
                        document.getElementById('alert-error').style.display = 'block';
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = 'SAVE';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('alert-error').innerHTML = 'Terjadi kesalahan saat menghubungi server';
                    document.getElementById('alert-error').style.display = 'block';
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'SAVE';
                });
        });
    });
</script>