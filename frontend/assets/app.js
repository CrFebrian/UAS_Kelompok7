document.getElementById('orderForm').addEventListener('submit', function(event){
    let isValid = true;

    const quantityInput = document.getElementById('quantity');
    const quantityError = document.getElementById('quantityError');
    const quantity = parseInt(quantityInput.value, 10);

    const productSelect = document.getElementById('productId');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const stock = parseInt(selectedOption.getAttribute('data-stock'), 10);

    quantityError.style.display = 'none';
    quantityError.textContent = '';

    if (isNaN(quantity) || quantity <= 0) {
        quantityError.textContent = 'Invalid Quantity';
        quantityError.style.display = 'block';
        isValid = false;
    } else if (quantity > stock) {
        quantityError.textContent = 'Out of Stock';
        quantityError.style.display = 'block';
        isValid = false;
    }

    const durationInput = document.getElementById('duration');
    const durationError = document.getElementById('durationError');
    const duration = parseInt(durationInput.value, 10);

    durationError.style.display = 'none';
    durationError.textContent = '';

    if (isNaN(duration) || duration < 1 || duration > 36) {
        durationError.textContent = 'Invalid Duration';
        durationError.style.display = 'block';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});