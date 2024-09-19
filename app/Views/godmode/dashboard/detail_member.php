<?php if(!empty(session('failed'))) { ?>
<div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
        <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
        <?= session('success')?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line text-black"></i>
    </button>
</div>
<?php }?>

<?php if(!empty(session('failed'))) { ?>
<div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
        <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
        <?= session('failed')?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line text-black"></i>
    </button>
</div>
<?php }?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <a class="text-white" href="<?= BASE_URL?>godmode/dashboard">BACK</a>
            </div>
            <div class="col-lg-10 mx-auto">
                <h4 class="text-center">example@gmail.com</h4>

                <!-- Detail -->
                <div class="dash-detailmember">
                    <div class="header">Detail</div>
                    
                    <!-- Membership Status -->
                    <div class="label">Membership Status</div>
                    <div class="value">
                        <span>normal Member</span>
                        <button class="upgrade-btn">Upgrade</button>
                    </div>

                    <!-- Registration date -->
                    <div class="label">Registration date</div>
                    <div class="value">26 September 2024</div>

                    <!-- Subscription Status -->
                    <div class="label">Subscription Status</div>
                    <div class="value">Active</div>

                    <!-- Subscription Plan -->
                    <div class="label">Subscription Plan</div>
                    <div class="value">6 Month</div>

                    <!-- Subscription date -->
                    <div class="label">subscription date</div>
                    <div class="value">28/19/2024 – 26/03/2025</div>
                </div>

                <!-- Referral -->
                <div class="dash-detailmember">
                    <div class="header">Referral</div>

                    <!-- Referral Code -->
                    <div class="label">Referral code</div>
                    <div class="value">12345</div>
                    
                    <!-- Referring member -->
                    <div class="label">Referring member</div>
                    <div class="value">
                        <span>-</span>
                        <button class="upgrade-btn">Add Referral</button>
                    </div>

                    <!-- Number of referrals -->
                    <div class="label">Number of referrals</div>
                    <div class="value">2</div>
                </div>
               
                <!-- Commission -->
                <div class="dash-detailmember">
                    <div class="header">Commission</div>

                    <!-- Pending Commission -->
                    <div class="label">Pending Commission</div>
                    <div class="value">EUR 10</div>
                    
                    <!-- Available Commission -->
                    <div class="label">Available Commission</div>
                    <div class="value">EUR 1100</div>
                    
                    <!-- Send commission -->
                    <div class="label">Send commission</div>
                    <div class="value">
                        <span></span>
                        <button class="upgrade-btn">Send</button>
                    </div>

                    <!-- Commission Sent -->
                    <div class="label">Commission Sent</div>
                    <div class="value">EUR 500</div>
                </div>
            </div>
        </div>
    </div>
</div>