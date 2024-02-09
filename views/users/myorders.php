<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;
use App\Helpers\Auth;

Auth::strictCheck();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </nav>
        <div class="mt-4 mb-5">
            <div class="d-md-flex justify-content-between">
                <h5 class="text-primary">My Orders</h5>
                <div class="mt-3 mt-md-0">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="all"
                            <?= isset($_GET["status"]) && $_GET["status"] === "all" ? "checked" : "" ?> checked>
                        <label class="form-check-label" for="all">
                            <a href="<?= HTTP::link("/users/myorders?status=all") ?>">
                                All
                            </a>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="progressing"
                            <?= isset($_GET["status"]) && $_GET["status"] == "0" ? "checked" : "" ?>>
                        <label class="form-check-label" for="progressing"><a
                                href="<?= HTTP::link("/users/myorders?status=0") ?>">Progressing</a></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="purchased"
                            <?= isset($_GET["status"]) && $_GET["status"] == "1" ? "checked" : "" ?>>
                        <label class="form-check-label" for="purchased">
                            <a href="<?= HTTP::link("/users/myorders?status=1") ?>">
                                Purchased
                            </a>
                        </label>
                    </div>
                </div>
            </div>
            <?php if(!$orders): ?>
            <div class="info text-center my-5 py-5">
                <h5 class="mb-3">There is no item in your orders.</h5>
                <a href="<?= HTTP::link("/products/") ?>" class="btn btn-primary">Continue Shopping</a>
            </div>
            <?php else: ?>
            <?php foreach ($orders as $order): ?>
            <div class="card mt-3 p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold">Invoice No.
                            <?= $order->id ?>
                        </h6>
                        <p class="fw-bold">
                            <i class="fa-solid fa-bullseye text-primary"></i>
                            <?= $order->status == 0 ? "Progressing" : "Purchased" ?>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="table-responsive">
                                <?php
                                    $total_items = 0;
                                    $total_price = 0;
                                    foreach (json_decode($order->cart) as $cart) {
                                        $total_items += $cart->qty;
                                    }
                                    foreach (json_decode($order->cart) as $cart) {
                                        $total_price += $cart->price * $cart->qty;
                                    }
                                    ?>
                                <table class="table" style="width: max-content;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Code No.</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php foreach (json_decode($order->cart) as $product): ?>
                                        <tr>
                                            <th scope="row">
                                                <?= $product->code ?>
                                            </th>
                                            <td class="d-flex align-items-center">
                                                <img src="<?= HTML::imgsrc("products/" . $product->image) ?>" width="80"
                                                    height="80" id="image" class="img-fluid img-thumbnail">
                                                <div class="ms-3">
                                                    <a href="<?= HTTP::link("/products/detail/$product->id") ?>">
                                                        <?= $product->name ?>
                                                    </a><br>
                                                    <a href="<?= HTTP::link("/products/filter?category=$product->category_id&sortby=default") ?>"
                                                        class="text-dark">
                                                        <small>
                                                            <?php
                                                                    foreach ($categories as $category) {
                                                                        if ($product->category_id == $category->id) {
                                                                            echo $category->name;
                                                                        }
                                                                    }
                                                                    ?>
                                                        </small>
                                                    </a>
                                                    <br>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $product->price ?>Ks
                                            </td>
                                            <td>
                                                <?= $product->qty ?>
                                            </td>
                                            <td>
                                                <?= $product->price * $product->qty ?>Ks
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">
                                                <span>Sub Total:
                                                    <?= $total_price ?>Ks
                                                </span><br>
                                                <span>Total:
                                                    <?= $total_price ?>Ks
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-3 mt-lg-0 d-md-flex justify-content-around d-lg-block">
                            <div class="mb-3">
                                <h6 class="fw-bold">Shipping Information</h6>
                                <?php foreach (json_decode($order->shipping_information) as $key => $info): ?>
                                <small>
                                    <i class="fa-solid fa-circle me-2 text-primary"></i>
                                    <?= $info ?>
                                </small><br>
                                <?php endforeach; ?>
                            </div>
                            <div class="">
                                <h6 class="fw-bold">Payment Method</h6>
                                <?php foreach (json_decode($order->payment_method) as $key => $payment): ?>
                                <small>
                                    <i class="fa-solid fa-circle me-2 text-primary"></i>
                                    <?= $payment ?>
                                </small><br>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>