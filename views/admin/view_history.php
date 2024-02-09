<?php

include(__DIR__ . "/components/head.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

$id = $_GET["id"] ?? 0;

?>

<div class="d-lg-flex justify-content-between align-items-center mb-3 border-bottom pt-3 pb-2 pb-md-3">
    <div class="">
        <h4 class="h4 mb-3 mb-lg-0">
            <?php
            echo $id && !isset($_GET["status"]) ? "All Order History (" . count($orders) . ")" : "";
            ?>
            <?= isset($_GET["status"]) && $_GET["status"] === "all" ? "All Order History (" . count($orders) . ")" : "" ?>
            <?= isset($_GET["status"]) && $_GET["status"] == "0" ? "Processing Order History (" . count($orders) . ")" : "" ?>
            <?= isset($_GET["status"]) && $_GET["status"] == "1" ? "Shipped Order History (" . count($orders) . ")" : "" ?>
            <span class="h6">
                (By
                <?php
                foreach ($users as $user) {
                    echo $user->id == $id ? $user->name : "";
                }
                ?>)
            </span>
        </h4>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="all"
                <?= isset($_GET["status"]) && $_GET["status"] === "all" ? "checked" : "" ?> checked>
            <label class="form-check-label" for="all">
                <a href="<?= HTTP::link("/admin/view_history/$id?status=all") ?>">
                    All
                </a>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="progressing"
                <?= isset($_GET["status"]) && $_GET["status"] == "0" ? "checked" : "" ?>>
            <label class="form-check-label" for="progressing"><a
                    href="<?= HTTP::link("/admin/view_history/$id?status=0") ?>">Progressing</a></label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="shipped"
                <?= isset($_GET["status"]) && $_GET["status"] == "1" ? "checked" : "" ?>>
            <label class="form-check-label" for="shipped">
                <a href="<?= HTTP::link("/admin/view_history/$id?status=1") ?>">
                    Shipped
                </a>
            </label>
        </div>
    </div>
</div>

<div class="mb-5">
    <?php foreach ($orders as $order): ?>
    <div class="card mt-3 p-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold">Invoice No.
                    <?= $order->id ?>
                </h6>
                <p class="fw-bold">
                    <i class="fa-solid fa-bullseye text-primary"></i>
                    <?= $order->status == 0 ? "Progressing" : "Shipped" ?>
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
                                            <?= $product->name ?>
                                            <br>
                                            <small>
                                                <?php
                                                        foreach ($categories as $category) {
                                                            if ($product->category_id == $category->id) {
                                                                echo $category->name;
                                                            }
                                                        }
                                                        ?>
                                            </small>
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
</div>

<?php include(__DIR__ . "/components/foot.php"); ?>