    
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>

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
  /* max-width: 1000px; */
  margin: 0 auto;
  /* padding: 20px; */
  /* border: 1px solid #e1e1e1; */
  border-radius: 8px;
  /* background: #f7f7f7; */
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

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
    
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
      const { paymentMethod, error } = await stripe.createPaymentMethod({
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


    $("#checking-referral").on("submit", function(e){
      e.preventDefault();
      const referral = $('#referral').val().trim();

      const formData = {
          referral: referral,
      };

      
      // Ajax Proccess
      $.ajax({
          url: '<?=BASE_URL?>widget/subscription/check_referral',
          type: 'POST',
          data: formData,
          success: function (ress) {
              // Parse Data
              let result = JSON.parse(ress)

              // Check if response success
              if(result.code == '200'){

                  $("#new-referral").val(`${referral}`);
                  $("#referral").attr('disabled','disabled');
                  $("#btn-referral-apply").attr('disabled','disabled');

                  // Enable and Disabled card plan
                  $(".text-regular").toggleClass('left-active left-disable');
                  $(".price-regular").toggleClass('right-active right-disable');
                  $(".text-referral").toggleClass('left-disable left-active');
                  $(".price-referral").toggleClass('right-disable right-active');

                  // One Month
                  $("#plan-onemonth").val('175,1 Month With Referral');

                  // Three Month
                  $("#plan-threemonth").val('525,3 Month With Referral');

                  // Six Month
                  $("#plan-sixmonth").val('1050,6 Month With Referral');

                  // Twelve Month
                  $("#plan-oneyear").val('2100,12 Month With Referral');

                  // Sweet Alert
                  Swal.fire({
                      text: `Valid Referral Code`,
                      showCloseButton: true,
                      showConfirmButton: false,
                      background: '#E1FFF7',
                      color: '#000000',
                      position: 'top-end',
                      timer: 3000,
                      timerProgressBar: true,
                  });

              }else{
                  // Sweet Alert
                  Swal.fire({
                      text: `${result.message}`,
                      showCloseButton: true,
                      showConfirmButton: false,
                      background: '#FFE4DC',
                      color: '#000000',
                      position: 'top-end',
                      timer: 3000,
                      timerProgressBar: true,
                  });
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              // Sweet Alert
              Swal.fire({
                  text: `${textStatus}`,
                  showCloseButton: true,
                  showConfirmButton: false,
                  background: '#FFE4DC',
                  color: '#000000',
                  position: 'top-end',
                  timer: 3000,
                  timerProgressBar: true,
              });
          }
      })
    });
</script>