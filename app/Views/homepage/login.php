<!-- Page Content -->
<section class="access-page">
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop id="bgVideo">
            <source src="<?= BASE_URL ?>assets/vid/bg-btclogin.mp4" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>
    
    <div class="access-options">
        <div class="access-card" onclick="window.location.href='<?= BASE_URL ?>elite/auth/login'">
            <h2><span>HEDGE</span> FUND</h2>
            <p>Direct and Personalized <strong>Bitcoin Wallet Management.</strong></p>
        </div>
        <div class="access-card">
            <h2><span>ELITE</span></h2>
            <p>Automate Bitcoin Operations: Entrust Our Brokers <strong>Through API Integration</strong></p>
        </div>
        <div class="access-card" onclick="window.location.href='<?= BASE_URL ?>member/auth/login'">
            <h2><span>BROKER</span> LUX</h2>
            <p>Automate Bitcoin Operations: Entrust Our Brokers <strong>Through API Integration</strong></p>
        </div>
    </div>
</section>
