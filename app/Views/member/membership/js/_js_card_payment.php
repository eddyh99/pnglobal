<script>
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
            // Append the Payment Method ID to the form and submit it
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method_id');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);

            // Submit the form to PHP for further processing
            form.submit();
        }
    });

    /*    $("#payment-form").on("submit", function(e) {
          $('#loadingcontent').modal('show'); 
        });*/
</script>