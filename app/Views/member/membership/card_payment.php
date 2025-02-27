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

                            <form id="payment-form" action="<?= BASE_URL ?>homepage/booking_proccess" method="POST">
                                <div class="payment-summary">
                                    <h1 class="fw-bold f-cormorant">Summary Meeting</h1>
                                    <p class="me-0 pe-0 me-md-5 pe-md-2">
                                        This is summary for your schedule meeting, before we accept please confirm your payment of <?= (empty($_SESSION["referral"]) ? "EUR 350" : FEEMEETING) ?>
                                    </p>
                                    <div class="mt-4 f-poppins pe-4">
                                        <label for="fname">Full Name</label> <br>
                                        <label class="fw-bold">
                                            <?= $_SESSION['client']['fname'] ?>
                                            <?= $_SESSION['client']['lname'] ?>
                                        </label>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="fname">Whatsapp mobile number </label> <br>
                                        <label class="fw-bold">
                                            <?= $_SESSION['client']['whatsapp'] ?>
                                        </label>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="fname">Email </label> <br>
                                        <ul class="email-list">
                                            <?php foreach ($_SESSION['client']['email'] as $email): ?>
                                                <li class="fw-bold">
                                                    <?= $email ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="fname">Timezone </label> <br>
                                        <label class="fw-bold">
                                            <?= $_SESSION['client']['timezone'] ?>
                                        </label>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="fname">Schedule</label> <br>
                                        <label class="fw-bold">
                                            <?php
                                            $date = explode('#', $_SESSION['client']['datetime']);
                                            $date = explode(' ', $date[0]);
                                            echo $date[0];
                                            ?>
                                        </label><br>
                                        <label class="fw-bold">
                                            <?php
                                            $date = explode('#', $_SESSION['client']['datetime']);
                                            $date = explode(' ', $date[0]);
                                            echo $date[1];
                                            ?>
                                            Until
                                            <?php
                                            $date = explode('#', $_SESSION['client']['datetime']);
                                            $date = explode(' ', $date[1]);
                                            echo $date[1];
                                            ?>
                                        </label>
                                    </div>
                                    <div class="mt-3 f-poppins pe-4">
                                        <label for="fname">Description </label> <br>
                                        <label class="fw-bold me-4">
                                            <?= $_SESSION['client']['description'] ?>
                                        </label>
                                    </div>

                                    <div class="mt-4 f-poppins pe-4">
                                        <small>Please fill your card*</small>
                                        <div id="card-element" class="StripeElement mt-2"></div>
                                        <div class="card-brand" id="card-brand"></div>
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
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS untuk form input */
    .form-control {
        border: 2px solid #BFA573;
        background-color: transparent;
        color: #080808;
        border-radius: 10px;
        box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.08);
        padding: 10px 15px;
        height: 45px;
    }

    .btn-footer-contactform {
        background-color: #BFA573;
        color: #000000;
        border: none;
        padding: 10px 30px;
        border-radius: 5px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .btn-footer-contactform:hover {
        background-color: #a38953;
        color: #000000;
    }

    /* Payment Summary Styling */
    .payment-form-wrapper {
        padding: 20px 0;
    }

    .payment-summary {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .payment-summary h1 {
        color: #333;
        font-size: 32px;
        margin-bottom: 15px;
    }

    .payment-summary p {
        color: #555;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .payment-summary label {
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .payment-summary .fw-bold {
        color: #333;
        font-size: 16px;
    }

    .payment-summary .email-list {
        list-style-type: none;
        padding-left: 0;
    }

    .payment-summary .email-list li {
        margin-bottom: 5px;
    }

    .StripeElement {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px;
        margin-top: 5px;
    }

    #submit-button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        background: linear-gradient(90deg, #b48b3d 0%, #bfa573 100%);
        transition: all 0.3s ease;
    }

    #submit-button:hover {
        background: linear-gradient(90deg, #a37b2d 0%, #af9563 100%);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .payment-summary {
            padding: 20px;
        }

        .payment-summary h1 {
            font-size: 28px;
        }
    }

    @media (max-width: 480px) {
        .payment-summary {
            padding: 15px;
        }

        .payment-summary h1 {
            font-size: 24px;
        }
    }
</style>

<script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');

        // Tampilkan notifikasi
        alert('Copied to clipboard: ' + element.value);
    }

    // Inisialisasi Stripe Elements
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan Stripe.js sudah dimuat
        if (typeof Stripe === 'undefined') {
            // Muat Stripe.js jika belum ada
            var script = document.createElement('script');
            script.src = 'https://js.stripe.com/v3/';
            script.onload = initializeStripe;
            document.head.appendChild(script);
        } else {
            initializeStripe();
        }
    });

    function initializeStripe() {
        // Ganti dengan Stripe publishable key Anda
        var stripe = Stripe('pk_test_your_publishable_key');
        var elements = stripe.elements();

        // Style untuk Stripe Elements
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Buat instance dari card Element
        var card = elements.create('card', {
            style: style
        });

        // Tambahkan instance ke container 'card-element'
        card.mount('#card-element');

        // Handle validasi real-time
        card.on('change', function(event) {
            var displayError = document.getElementById('card-brand');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }

            // Tampilkan brand kartu jika tersedia
            if (event.brand) {
                displayError.textContent = 'Card Type: ' + event.brand;
            }
        });

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            // Disable the submit button to prevent repeated clicks
            document.getElementById('submit-button').disabled = true;

            // Show loading modal
            $('#loading').modal('show');

            var cardholderName = document.getElementById('cardholder-name').value;
            var billingLine1 = document.getElementById('billing-address-line1').value;
            var billingCity = document.getElementById('billing-address-city').value;
            var billingState = document.getElementById('billing-address-state').value;
            var billingZip = document.getElementById('billing-address-zip').value;
            var billingCountry = document.getElementById('billing-address-country').value;

            stripe.createToken(card, {
                name: cardholderName,
                address_line1: billingLine1,
                address_city: billingCity,
                address_state: billingState,
                address_zip: billingZip,
                address_country: billingCountry
            }).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-brand');
                    errorElement.textContent = result.error.message;
                    document.getElementById('submit-button').disabled = false;
                    $('#loading').modal('hide');
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    }
</script>