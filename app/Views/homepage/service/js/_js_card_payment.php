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
        var stripe = Stripe('<?= PUBLIC_KEY ?>'); // Replace with your Stripe publishable key
        var elements = stripe.elements();

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
        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');

        card.on('change', function(event) {
            var brandElement = document.getElementById('card-brand');
            if (event.brand && event.brand !== 'unknown') {
                brandElement.style.backgroundImage = `url('https://example.com/icons/${event.brand}.svg')`;
            } else {
                brandElement.style.backgroundImage = 'none';
            }

            var errorElement = document.getElementById('card-errors');
            if (event.error) {
                errorElement.textContent = event.error.message;
            } else {
                errorElement.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Disable the form submit button to prevent multiple submissions
            document.getElementById('submit-button').disabled = true;

            // Capture cardholder name and billing details
            var cardholderName = document.getElementById('cardholder-name').value;
            var billingDetails = {
                name: cardholderName,
                address: {
                    line1: document.getElementById('billing-address-line1').value,
                    city: document.getElementById('billing-address-city').value,
                    state: document.getElementById('billing-address-state').value,
                    postal_code: document.getElementById('billing-address-zip').value,
                    country: document.getElementById('billing-address-country').value
                }
            };

            // Create the Payment Method with Stripe
            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: billingDetails
            });

            if (error) {
                // Show error and re-enable the button
                document.getElementById('card-errors').textContent = error.message;
                document.getElementById('submit-button').disabled = false;
            } else {
                // Create a hidden input field for the token
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);

                // Show loading modal if exists
                if ($("#loadingcontent").length > 0) {
                    $("#loadingcontent").modal("show");
                }

                // Submit the form to PHP for further processing
                form.submit();
            }
        });
    }

    // Fungsi untuk menampilkan pesan sukses dan redirect otomatis
    function showSuccessAndRedirect(message) {
        // Buat modal jika belum ada
        if ($("#paymentSuccessModal").length === 0) {
            $("body").append(`
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
                                <!-- Pesan akan dimuat secara dinamis -->
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Set pesan default jika tidak ada pesan yang diberikan
        var defaultMessage = `
            <div class="text-center">
                <div class="mb-4">
                    <i class="ri-checkbox-circle-line text-success" style="font-size: 4rem;"></i>
                </div>
                <p>Your payment is being processed and your account will be ready within 48 hours.</p>
                <p>We will send you an email when your account is active.</p>
            </div>
        `;

        // Set pesan dan tampilkan modal
        $("#paymentSuccessModal .modal-body").html(message || defaultMessage);
        $("#paymentSuccessModal").modal("show");

        // Set timer untuk menutup modal dan redirect
        setTimeout(function() {
            $("#paymentSuccessModal").modal("hide");
            setTimeout(function() {
                window.location.href = "<?= BASE_URL ?>homepage/tutorial";
            }, 500);
        }, 3000); // Tampilkan modal selama 3 detik sebelum redirect
    }

    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');

        // Tampilkan notifikasi
        alert('Copied to clipboard: ' + element.value);
    }
</script>