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
            <div class="col-lg-12">
                <div class="row referral-container">
                    <div class="col-md-10">
                        <div class="referral-card">
                            <div class="referral-link text-white">
                                Referral link:
                                <a href="https://pnglobalinternational.com/<?= $refcode ?>" target="_blank">
                                    https://pnglobalinternational.com/<?= $refcode ?>
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
                    <div class="col-md-2">
                        <div class="active-api-card text-white">
                            <?php if (isset(session()->get('user_data')['api_key']) && isset(session()->get('user_data')['api_secret']) && !empty(session()->get('user_data')['api_key']) && !empty(session()->get('user_data')['api_secret'])): ?>
                                Active
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 50 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M45 0H5C3.67392 0 2.40215 0.526784 1.46447 1.46447C0.526784 2.40215 0 3.67392 0 5V25C0 26.3261 0.526784 27.5979 1.46447 28.5355C2.40215 29.4732 3.67392 30 5 30H45C46.3261 30 47.5979 29.4732 48.5355 28.5355C49.4732 27.5979 50 26.3261 50 25V5C50 3.67392 49.4732 2.40215 48.5355 1.46447C47.5979 0.526784 46.3261 0 45 0ZM18.225 22L17.5 19.325H12.9L12.175 22H7.925L12.5 7.675H17.725L22.5 22H18.225ZM34.075 14.15C33.8951 14.7425 33.588 15.2886 33.175 15.75C32.7054 16.2366 32.1331 16.6124 31.5 16.85C30.7002 17.1455 29.8525 17.2896 29 17.275H27.9V22H24V7.725H29C30.447 7.62052 31.8836 8.03731 33.05 8.9C33.5194 9.32202 33.887 9.84498 34.1252 10.4296C34.3633 11.0141 34.4659 11.6451 34.425 12.275C34.4108 12.9148 34.2926 13.5481 34.075 14.15ZM40.525 22H36.65V7.725H40.525V22ZM16.125 13.825L16.725 16.15H13.7L14.3 13.825C14.3 13.5 14.5 13.125 14.6 12.65C14.7 12.175 14.825 11.7 14.925 11.225C15.0295 10.8297 15.1129 10.4291 15.175 10.025C15.175 10.35 15.35 10.75 15.45 11.275L15.825 12.725L16.125 13.825ZM30.1 11.325C30.2375 11.4667 30.3441 11.6354 30.4129 11.8205C30.4818 12.0055 30.5114 12.2029 30.5 12.4C30.5139 12.7695 30.4182 13.1348 30.225 13.45C30.0605 13.6971 29.8252 13.8888 29.55 14C29.2575 14.1229 28.9422 14.1825 28.625 14.175H27.85V10.85H28.85C29.0604 10.8404 29.2705 10.873 29.4681 10.946C29.6656 11.019 29.8465 11.1309 30 11.275L30.1 11.325Z" fill="#0DB82D" />
                                </svg>
                            <?php else: ?>
                                Inactive
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 50 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M45 0H5C3.67392 0 2.40215 0.526784 1.46447 1.46447C0.526784 2.40215 0 3.67392 0 5V25C0 26.3261 0.526784 27.5979 1.46447 28.5355C2.40215 29.4732 3.67392 30 5 30H45C46.3261 30 47.5979 29.4732 48.5355 28.5355C49.4732 27.5979 50 26.3261 50 25V5C50 3.67392 49.4732 2.40215 48.5355 1.46447C47.5979 0.526784 46.3261 0 45 0ZM18.225 22L17.5 19.325H12.9L12.175 22H7.925L12.5 7.675H17.725L22.5 22H18.225ZM34.075 14.15C33.8951 14.7425 33.588 15.2886 33.175 15.75C32.7054 16.2366 32.1331 16.6124 31.5 16.85C30.7002 17.1455 29.8525 17.2896 29 17.275H27.9V22H24V7.725H29C30.447 7.62052 31.8836 8.03731 33.05 8.9C33.5194 9.32202 33.887 9.84498 34.1252 10.4296C34.3633 11.0141 34.4659 11.6451 34.425 12.275C34.4108 12.9148 34.2926 13.5481 34.075 14.15ZM40.525 22H36.65V7.725H40.525V22ZM16.125 13.825L16.725 16.15H13.7L14.3 13.825C14.3 13.5 14.5 13.125 14.6 12.65C14.7 12.175 14.825 11.7 14.925 11.225C15.0295 10.8297 15.1129 10.4291 15.175 10.025C15.175 10.35 15.35 10.75 15.45 11.275L15.825 12.725L16.125 13.825ZM30.1 11.325C30.2375 11.4667 30.3441 11.6354 30.4129 11.8205C30.4818 12.0055 30.5114 12.2029 30.5 12.4C30.5139 12.7695 30.4182 13.1348 30.225 13.45C30.0605 13.6971 29.8252 13.8888 29.55 14C29.2575 14.1229 28.9422 14.1825 28.625 14.175H27.85V10.85H28.85C29.0604 10.8404 29.2705 10.873 29.4681 10.946C29.6656 11.019 29.8465 11.1309 30 11.275L30.1 11.325Z" fill="#F80D0D" />
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row statistics-cards mb-4">
                    <div class="col-md-6">
                        <div class="custom-card left-card">
                            <div class="card-row card-top">
                                Capital This Periode
                            </div>
                            <div class="card-row card-bottom">
                                <?= '$ ' . number_format($capital, 0, '.', ',') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-card right-card">
                            <div class="card-row card-top">
                                Account Status : Active until 25-02-2025
                            </div>
                            <div class="card-row card-bottom d-flex justify-content-between align-items-center">
                                <div class="left-column">
                                    20 Days remaining
                                </div>
                                <div class="right-column">
                                    <button class="btn-renew">Renew</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Binace Card -->
                <div class="binance-fullcard">
                    <div class="binance-fullcard-header">
                        Connect Binance API
                    </div>
                    <div class="binance-detailcard">
                        <div class="label">
                            API Key
                        </div>
                        <div class="value">
                            adsjJN945wkngsflkn
                        </div>
                        <div class="label">
                            API Secret
                        </div>
                        <div class="value">
                            adsjJN945wadsjJN945wkngsflkn
                        </div>
                    </div>
                    <div class="binance-fullcard-footer">
                        <button class="edit-btn">Edit</button>
                    </div>
                </div>
                <!-- Tombol di luar binance-fullcard -->
                <div class="binance-button-row">
                    <button class="get-api-btn">How to get API?</button>
                    <button class="support-btn">Contact Support</button>
                </div>
                <div class="col-lg-12 dash-table-totalmember">
                    <h4 class="text-white my-3 text-uppercase fw-bold">Membership History</h4>
                    <table id="table_totalmember" class="table table-striped" style="width:100%">
                        <thead class="thead_totalmember">
                            <tr>
                                <th>DATE</th>
                                <th>CAPITAL</th>
                                <th>PAYMENT AMOUNT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>