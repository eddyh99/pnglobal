<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <div class="row referral-container">
                    <div class="col-md-10">
                        <div class="referral-card">
                            <div class="referral-link text-white">
                                Referral link:
                                <a href="https://pnglobalinternational.com/referral-blablabla" target="_blank">
                                    https://pnglobalinternational.com/referral-blablabla
                                </a>
                            </div>
                            <div class="referral-qr">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.303 3.33333C10.303 1.49238 11.8022 0 13.6515 0C15.5008 0 17 1.49238 17 3.33333C17 5.17428 15.5008 6.66667 13.6515 6.66667C12.7177 6.66667 11.8738 6.28596 11.2671 5.67347L6.6317 8.8295C6.6745 9.0425 6.697 9.2625 6.697 9.4872C6.697 9.9322 6.609 10.3576 6.44959 10.7464L11.5323 14.0858C12.1092 13.6161 12.8473 13.3333 13.6515 13.3333C15.5008 13.3333 17 14.8257 17 16.6667C17 18.5076 15.5008 20 13.6515 20C11.8022 20 10.303 18.5076 10.303 16.6667C10.303 16.1845 10.4062 15.7255 10.5917 15.3111L5.55007 11.9987C4.96196 12.5098 4.1916 12.8205 3.34848 12.8205C1.49917 12.8205 0 11.3281 0 9.4872C0 7.64623 1.49917 6.15385 3.34848 6.15385C4.4119 6.15385 5.35853 6.64725 5.97145 7.41518L10.4639 4.35642C10.3594 4.03359 10.303 3.6896 10.303 3.33333Z" fill="#B48B3D" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                                    <path d="M4 10C4 7.17157 4 5.75736 4.87868 4.87868C5.75736 4 7.17157 4 10 4H13C15.8284 4 17.2426 4 18.1213 4.87868C19 5.75736 19 7.17157 19 10V15C19 17.8284 19 19.2426 18.1213 20.1213C17.2426 21 15.8284 21 13 21H10C7.17157 21 5.75736 21 4.87868 20.1213C4 19.2426 4 17.8284 4 15V10Z" stroke="#BFA573" />
                                    <path d="M4 18C2.34315 18 1 16.6569 1 15V9C1 5.22876 1 3.34315 2.17157 2.17157C3.34315 1 5.22876 1 9 1H13C14.6569 1 16 2.34315 16 4" stroke="#BFA573" />
                                </svg>
                                <p>Show QR Code</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="account-status-card">
                <div class="account-status-header">
                    Account Status
                </div>
                <div class="account-status-detail">
                    <div class="label">
                        Start Date
                    </div>
                    <div class="value">
                        01 January 2023
                    </div>
                    <div class="label">
                        End Date
                    </div>
                    <div class="value">
                        31 December 2023
                    </div>
                </div>
                <div class="account-status-footer">
                    <button class="membership-btn" onclick="window.location.href='<?= BASE_URL ?>member/membership/set_investment_capital'">Extend / New Membership</button>
                </div>
            </div>
        </div>
    </div>
</div>