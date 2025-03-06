<section class="tutorial-page">
    <div class="tutorial-container">
        <h1 class="tutorial-title">HOW TO GET API FROM BINANCE</h1>

        <div class="tutorial-tabs">
            <div class="tab-buttons">
                <button class="tab-button active" data-tab="desktop">DESKTOP</button>
                <button class="tab-button" data-tab="mobile">MOBILE</button>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="desktop">
                    <div class="tutorial-steps">
                        <div class="tutorial-step">
                            <h3>1. <span class="highlight">Log in</span> to your Binance account.</h3>
                        </div>

                        <div class="tutorial-step">
                            <h3>2. Click on the <span class="highlight">search bar</span> and type "<span class="highlight">API</span>".</h3>
                            <div class="tutorial-image">
                                <img src="/assets/img/2a.png" alt="Desktop Search Bar">
                            </div>
                        </div>

                        <!-- Tambahkan langkah-langkah lainnya sesuai kebutuhan -->
                    </div>
                </div>

                <div class="tab-pane" id="mobile">
                    <div class="tutorial-steps">
                        <div class="tutorial-step">
                            <h3>1. <span class="highlight">Log in</span> to your Binance account.</h3>
                            <div class="tutorial-image">
                                <img src="/assets/img/1. login.png" alt="Mobile Login">
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>2. Click on the <span class="highlight">search bar</span> and type "<span class="highlight">API</span>".</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/2a.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                                <div class="tutorial-image">
                                    <img src="/assets/img/2b.png" alt="Mobile Search Step 2">
                                    <!-- <div class="image-label">2B</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>3. Select <span class="highlight">API Management</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/3.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>4. Ensure the <span class="highlight">default security option</span> is off (unchecked).</h3>
                            <h3>5. Click <span class="highlight">Create API</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/4.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>6. Choose <span class="highlight">"System Generated"</span> and click <span class="highlight">"next"</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/6.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>7. Enter a <span class="highlight">name for your API</span> account and click <span class="highlight">"Next"</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/7.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>8. Once the API is created, click <span class="highlight">"Edit Restrictions"</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/8.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>9. Check the box for <span class="highlight">"Enable Spot & Margin Trading"</span>.</h3>
                            <h3>10. Click <span class="highlight">"Save"</span>.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/9.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-step">
                            <h3>11. <span class="highlight"> Copy the "API key" and "Secret API"</span> to paste into the Satoshi Signal platform.</h3>
                            <h3>Note : The Secret API can only be viewed once. If you forget it, you can delete the API and create a new one.</h3>
                            <div class="tutorial-image-container">
                                <div class="tutorial-image">
                                    <img src="/assets/img/10.png" alt="Mobile Search Step 1">
                                    <!-- <div class="image-label">2A</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and panes
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Show corresponding tab pane
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>