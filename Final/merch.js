const imageElements = document.getElementsByTagName('img');
const checkboxInputs = document.getElementsByTagName('input');
const checkoutButton = document.getElementById('checkout');
const creditParagraph = document.getElementsByTagName('p')[1];
const couponBox = document.getElementById('coupon');
const total_p = document.getElementsByTagName('p')[6];

const prices = [10.10, 11.11, 12.50, 15.10];
let defaultCredit = document.getElementById('credit');
let creditDisplay = defaultCredit.innerHTML;
let credit = creditDisplay.replace('Your Credit: $', '');
console.log(credit);

window.onload = function () {
    update_credit();
};

// Loads initial credit and prices
const priceSpans = document.getElementsByTagName('span');
for (let i = 0; i < prices.length; i++) {
    priceSpans[i].innerHTML = `$${prices[i].toFixed(2)}`;
}

// First event listener when an image is clicked
for (let j = 0; j < imageElements.length; j++) {
    imageElements[j].addEventListener('click', function () {
        if (!checkboxInputs[j].disabled) {
            checkboxInputs[j].checked = !checkboxInputs[j].checked;
        }
    });
}

// Second event listener for when the checkout button is clicked
function validate_coupon_code() {
    let couponCode = couponBox.value;
    let couponDiscount = 0;

    if (couponCode === 'COUPON5') {
        couponDiscount += 5;
    } else if (couponCode === 'COUPON10') {
        couponDiscount += 10;
    } else if (couponCode === 'COUPON20') {
        couponDiscount += 20;
    } else {
        couponBox.value = '';
        return;
    }

    credit += couponDiscount;
    update_credit(credit);
    total_p.innerHTML = '';
    couponBox.value = '';
}

let checkedItems = [];
checkoutButton.addEventListener('click', function () {
    validate_coupon_code();
    sales_total(prices);
    
});

// Third event listener for when the Coupon box button is hit Enter
couponBox.addEventListener('keydown', function (event) {
    if (event.key === "Enter") {
        validate_coupon_code();
    }
});

// Updates credit
function update_credit() {
    const username = (function (cookieName) {
        let cookies = document.cookie.split('; ');
        for (let i = 0; i < cookies.length; i++) {
            let [name, value] = cookies[i].split('=');
            if (name === cookieName) {
                return value;
            }
        }
        return null; // Return null if the cookie is not found
    })('username');

    const request = new XMLHttpRequest();
    request.onload = function () {
        if (this.status === 200) {
            let creditDisplay = this.responseText.trim(); // Remove any leading/trailing spaces
            let creditValue = parseFloat(creditDisplay.replace('$', '')); // Remove "$" and convert to number
            credit = creditValue; // Update the credit variable with the new value
            creditParagraph.innerHTML = `Your Credit: $${creditValue.toFixed(2)}`; // Update the UI
            console.log(credit);
        }
    };

    request.open('POST', 'money.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(`username=${username}&credit=${credit}`);
}

// Calculates total with tax and updates credit
function sales_total(arr) {
    let checkedItems = [];
    let totalInCents = 0;
    const taxRate = 0.0725;
    let totalPrice = 0;

    for (let i = 0; i < 4; i++) {
        if (checkboxInputs[i].checked === true) {
            checkedItems.push(prices[i]);
            totalPrice += prices[i]; // Add the price of each checked item
        } else{
            total_p.innerHTML = '';
        }
    }

    // Correct summing of prices
    for (let price of checkedItems) {
        totalInCents += Math.round(price * 100); // Convert each price to cents
    }

    // Calculate the tax in cents
    let taxInCents = Math.round(totalInCents * taxRate);

    // Total with tax in cents
    let totalPlusTaxInCents = totalInCents + taxInCents;

    // Banker's rounding
    let lastDigit = totalPlusTaxInCents % 10;
    let cents = Math.floor(totalPlusTaxInCents / 10) % 100;

    if (lastDigit === 5) {
        if (cents % 2 === 0) {
            totalPlusTaxInCents -= 5; // Round down if even
        } else {
            totalPlusTaxInCents += 5; // Round up if odd
        }
    }

    // Convert back to dollars and format
    let fTotal = (totalPlusTaxInCents / 100);
    let subtotal = (totalInCents / 100);

    if (fTotal > credit) {
        alert('You have insufficient credit for this purchase.');
        total_p.innerHTML = '';
        return;
    } else if (fTotal === 0) {
        return;
    }

    credit -= fTotal; // Deduct final total from credit
    update_credit(credit);
    total_p.innerHTML = `&nbsp;&nbsp;&nbsp;$${subtotal.toFixed(2)}<br>+ sales tax (7.25%)<br>= $${fTotal.toFixed(2)}`;

    for (let i = 0; i < checkboxInputs.length; i++) {
        if (checkboxInputs[i].checked) {
            checkboxInputs[i].disabled = true;
            checkboxInputs[i].checked = false;
        }
    }
    couponBox.value = "";
}