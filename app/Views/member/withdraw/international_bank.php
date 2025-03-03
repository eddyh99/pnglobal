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
<div class="content-page mb-5 withdraw-usdt">
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
                <div class="withdraw-comission">

                    <div class="row referral-cards mb-4">
                        <div class="col-md-6">
                            <div class="custom-card left-card">
                                <div class="card-row card-top">
                                    Available Commission to Withdraw
                                </div>
                                <div class="card-row card-bottom">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <form action="<?= BASE_URL ?>member/withdraw/request_withdraw" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Withdraw Form</h4>
                        </div>
                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <input type="hidden" name="type" value="fiat">
                                    <!-- <div class="wrapper-addreferral">
                                        <label for="amount">Amount To Withdraw</label>
                                        <input type="number" name="amount" class="form-control">
                                    </div> -->
                                    <div class="wrapper-addreferral">
                                        <label for="recipient">Recipient Name</label>
                                        <input type="text" name="recipient" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="wallet_address">Account Number</label>
                                        <input type="text" name="wallet_address" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="swift_code">SWIFT Code</label>
                                        <input type="text" name="swift_code" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral address-wrapper">
                                        <label for="address">Address</label>
                                        <input type="text" id="address_line1" class="form-control" placeholder="First Line">
                                    </div>
                                    <div class="wrapper-addreferral address-wrapper">
                                        <input type="text" id="city" class="form-control" placeholder="City">
                                    </div>
                                    <div class="wrapper-addreferral address-group address-wrapper">
                                        <input type="text" id="state" class="form-control" placeholder="State">
                                        <input type="text" id="postal_code" class="form-control" placeholder="Postal Code">
                                    </div>
                                    <!-- Field tersembunyi untuk menggabungkan nilai address -->
                                    <input type="hidden" name="address" id="address">
                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary text-black">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalAvailableCommission" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Pesan akan dimuat secara dinamis -->
            </div>
        </div>
    </div>
</div>