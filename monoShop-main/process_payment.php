<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <form action="charge.php" method="post" id="payment-form">
        <div class="form-row">
            <label for="card-element">
            Credit or debit card
            </label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit">Submit Payment</button>
    </form>

    <script>
    var stripe = Stripe('pk_test_51NRK2oAOXQtmdB1JT50zfW1cPzI9HAuz7ayee9JbJEZvaJn8r9DYoeDxmmHCntHS0F90a3HhJbt4N3ZtxAlKFEif00wBXLgxGY');
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

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
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
                console.log('Stripe token created:', result.token); // Logging token
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
        console.log('Form contents before submission:', form); // Logging form
        console.log('Form submitted!'); // Log form submission
        form.submit();
    }
    </script>
</body>
</html>
