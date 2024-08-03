<style>
    /* Base styles for the Stripe Elements container */
.StripeElement {
  box-sizing: border-box;
  width: 100%;
  height: 40px;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: white;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

/* Customizing the placeholder text */
::placeholder {
  color: #aab7c4;
}

/* Style for the card number input field */
#card-number-element {
  margin-bottom: 20px;
}

/* Style for the expiration date and CVC input fields */
#card-expiry-element,
#card-cvc-element {
  display: inline-block;
  width: 48%;
  margin-right: 4%;
}

#card-cvc-element {
  margin-right: 0;
}

/* Adding some margin to the form container */
#payment-form {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #e1e1e1;
  border-radius: 8px;
  background: #f7f7f7;
}

button {
  background-color: #6772e5;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 10px 15px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 200ms;
}

button:hover {
  background-color: #5469d4;
}

/* Error message styling */
.error-message {
  color: #fa755a;
  font-size: 14px;
  margin-top: 12px;
}

/* Card brand icon styles */
.card-brand {
  position: absolute;
  right: 12px;
  top: 10px;
  width: 36px;
  height: 24px;
  background-size: contain;
  background-repeat: no-repeat;
}

</style>

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
    var card = elements.create('card', {style: style});
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
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      stripe.createToken(card).then(function(result) {
        if (result.error) {
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          stripeTokenHandler(result.token);
        }
      });
    });

    function stripeTokenHandler(token) {
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      form.submit();
    }
</script>