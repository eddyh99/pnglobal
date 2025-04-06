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
<?php require_once("countries-list.php") ?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12 px-2">
                <!-- Payment Form Wrapper -->
                <div class="payment-form-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-8 my-4">
                            <?php if (@isset($_SESSION["error_email"])) { ?>
                                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="notif-login f-poppins"><?= $_SESSION["error_email"] ?></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            <?php } ?>

                            <form id="payment-form" method="POST">
                                <div class="payment-summary">
                                    <h1 class="fw-bold f-cormorant">Summary Membership</h1>

                                    <input type="hidden" name="amount" value="<?= $payment_data['amount'] ?>">

                                    <div class="mt-4 f-poppins pe-4">
                                        <small>Please fill your card*</small>
                                        <div id="card-element" class="StripeElement mt-2"></div>
                                        <div class="card-brand" id="card-brand"></div>
                                        <div id="card-errors" class="text-danger mt-2"></div>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="cardholder-name">Cardholder's Name</label>
                                        <input type="text" id="cardholder-name" placeholder="Full Name" class="form-control" required>
                                    </div>

                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="billing-address-line1">Billing Address</label>
                                        <input type="text" id="billing-address-line1" class="form-control mt-1" placeholder="Address Line 1" required>
                                        <input type="text" id="billing-address-city" class="form-control mt-1" placeholder="City" required>
                                        <input type="text" id="billing-address-state" class="form-control mt-1" placeholder="State" required>
                                        <input type="text" id="billing-address-zip" class="form-control mt-1" placeholder="Postal Code" required>
                                        <select id="billing-address-country" class="form-control mt-1" required>
                                            <option value>---- Country ----</option>
                                            <?php foreach ($countries_list  as $dt) { ?>
                                                <option value="<?= $dt["code"] ?>"><?= $dt["name"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="mt-4 f-poppins">
                                        <button type="submit" id="submit-button" class="btn btn-footer-contactform">CONFIRM</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spinner for Loading form -->
<div class="modal fade" id="loadingcontent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <!-- <span class="visually-hidden">Loading...</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan pesan sukses -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentSuccessModalLabel">Payment Successful</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="mb-4">
                        <i class="ri-checkbox-circle-line text-success" style="font-size: 4rem;"></i>
                    </div>
                    <p>Your payment is being processed and your account will be ready within 48 hours.</p>
                    <p>We will send you an email when your account is active.</p>
                </div>
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

<script>
    // Tampilkan modal sukses jika ada flash data success
    <?php if (!empty(session('success'))) { ?>
        $(document).ready(function() {
            // Tampilkan modal sukses
            $("#paymentSuccessModal").modal("show");

            // Set timer untuk menutup modal dan redirect
            setTimeout(function() {
                $("#paymentSuccessModal").modal("hide");
                setTimeout(function() {
                    window.location.href = "<?= BASE_URL ?>member/dashboard";
                }, 500);
            }, 3000); // Tampilkan modal selama 3 detik sebelum redirect
        });
    <?php } ?>
</script>