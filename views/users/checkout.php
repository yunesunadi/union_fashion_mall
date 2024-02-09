<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;
use App\Helpers\Auth;

$auth = Auth::strictCheck();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row mt-4 mb-5 my-lg-4">
            <div class="col-lg-8">
                <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
                <div class=" alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                endif;
                unset($_SESSION["error"]);
                ?>
                <h5 class="text-primary">Shipping Information</h5>
                <form action="<?= HTTP::link("/users/checkout") ?>" method="post" id="checkout-form" class="pt-2 pb-4">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="first_name" id="first-name"
                                    placeholder="">
                                <label for="first_name">First Name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="last_name" id="last-name" placeholder="">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="phone_no" id="phoneno" placeholder="">
                        <label for="phone_no">Phone Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="address" id="address" placeholder="">
                        <label for="address">Address</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="city" id="city" placeholder="">
                                <label for="city">City</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="region" id="region" placeholder="">
                                <label for="region">Region</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="postal_code" id="postal-code"
                                    placeholder="">
                                <label for="postal_code">Postal Code</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="text-primary">Payment Method</h5>
                        <div class="d-flex gap-2 text-primary">
                            <i class="fa-brands fa-cc-visa fs-1"></i>
                            <i class="fa-brands fa-cc-mastercard fs-1"></i>
                            <i class="fa-brands fa-cc-jcb fs-1"></i>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="card_number" id="card-number" placeholder="">
                        <label for="card_number">Card Number</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nameoncard" id="nameoncard"
                                    placeholder="">
                                <label for="nameoncard">Name on card</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="mmyy" id="mmyy" placeholder="">
                                <label for="mmyy">MM/YY</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="">
                                <label for="cvv">CVV</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary text-white ms-auto">Complete Order</button>
                    </div>
                </form>
            </div>
            <div class="col-md-7 col-lg-4">
                <?php
                $total_items = 0;
                $total_price = 0;
                if (isset($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $cart) {
                        $total_items += $cart["qty"];
                    }
                    foreach ($_SESSION["cart"] as $cart) {
                        $total_price += $cart["price"] * $cart["qty"];
                    }
                }
                ?>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-primary fw-bold mb-3">Order Summary
                            <?php echo "(" . $total_items . " items)" ?>
                        </h6>
                        <div class="d-flex justify-content-between">
                            <span class="card-text">Sub Total</span>
                            <span class="card-text">
                                <?= $total_price ?>Ks
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="card-text">Delivery</span>
                            <span class="card-text">-</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="card-text">Sales Tax</span>
                            <span class="card-text">-</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="card-text fw-bold">Total</span>
                            <span class="card-text fw-bold">
                                <?= $total_price ?>Ks
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
const checkoutForm = document.querySelector("#checkout-form");
const firstNameInput = document.querySelector("#first-name");
const lastNameInput = document.querySelector("#last-name");
const emailInput = document.querySelector("#email");
const phonenoInput = document.querySelector("#phoneno");
const addressInput = document.querySelector("#address");
const cityInput = document.querySelector("#city");
const regionInput = document.querySelector("#region");
const postalCodeInput = document.querySelector("#postal-code");
const cardNumberInput = document.querySelector("#card-number");
const nameOnCardInput = document.querySelector("#nameoncard");
const mmyyInput = document.querySelector("#mmyy");
const cvvInput = document.querySelector("#cvv");

document.addEventListener("DOMContentLoaded", () => {
    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("checkoutValue");
    }

    checkoutForm.addEventListener("submit", () => {
        sessionStorage.setItem("checkoutValue", JSON.stringify(
            [firstNameInput.value, lastNameInput.value, emailInput.value, phonenoInput.value,
                addressInput.value, cityInput.value, regionInput.value, postalCodeInput.value,
                cardNumberInput.value, nameOnCardInput.value, mmyyInput.value, cvvInput.value
            ]
        ));
    });

    const [firstNameValue, lastNameValue, emailValue, phonenoValue,
        addressValue, cityValue, regionValue, postalCodeValue,
        cardNumberValue, nameOnCardValue, mmyyValue, cvvValue
    ] = JSON.parse(sessionStorage.getItem(
        "checkoutValue")) || [];
    firstNameInput.value = firstNameValue || "";
    lastNameInput.value = lastNameValue || "";
    emailInput.value = emailValue || "";
    phonenoInput.value = phonenoValue || "";
    addressInput.value = addressValue || "";
    cityInput.value = cityValue || "";
    regionInput.value = regionValue || "";
    postalCodeInput.value = postalCodeValue || "";
    cardNumberInput.value = cardNumberValue || "";
    nameOnCardInput.value = nameOnCardValue || "";
    mmyyInput.value = mmyyValue || "";
    cvvInput.value = cvvValue || "";
});
</script>