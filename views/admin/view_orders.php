<?php

include(__DIR__ . "/components/head.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

?>

<?php if (isset($_SESSION["success"])): ?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fa-solid fa-circle-info me-2"></i>
    <?= $_SESSION["success"] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
endif;
unset($_SESSION["success"]);
?>

<div
    class="d-md-flex justify-content-between align-items-center mb-3 border-bottom pb-2 pb-md-3 <?= isset($_SESSION["success"]) ? "" : "pt-3" ?>">
    <h3 class="h3 mb-3 mb-md-0">
        <?php
        $url = substr($_SERVER["REQUEST_URI"], strlen(HTTP::$folder . "/admin/view_orders"));
        echo $url === "/" ? "All Orders (" . count($orders) . ")" : "";
        ?>
        <?= isset($_GET["status"]) && $_GET["status"] === "all" ? "All Orders (" . count($orders) . ")" : "" ?>
        <?= isset($_GET["status"]) && $_GET["status"] == "0" ? "Processing Orders (" . count($orders) . ")" : "" ?>
        <?= isset($_GET["status"]) && $_GET["status"] == "1" ? "Shipped Orders (" . count($orders) . ")" : "" ?>
    </h3>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="all"
                <?= isset($_GET["status"]) && $_GET["status"] === "all" ? "checked" : "" ?> checked>
            <label class="form-check-label" for="all">
                <a href="<?= HTTP::link("/admin/view_orders/?status=all") ?>">
                    All
                </a>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="progressing"
                <?= isset($_GET["status"]) && $_GET["status"] == "0" ? "checked" : "" ?>>
            <label class="form-check-label" for="progressing"><a
                    href="<?= HTTP::link("/admin/view_orders/?status=0") ?>">Progressing</a></label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="shipped"
                <?= isset($_GET["status"]) && $_GET["status"] == "1" ? "checked" : "" ?>>
            <label class="form-check-label" for="shipped">
                <a href="<?= HTTP::link("/admin/view_orders/?status=1") ?>">
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
            <div class="d-flex justify-content-between align-items-center mb-2 mb-md-4">
                <h6 class="fw-bold d-flex align-self-md-center">Invoice No.
                    <?= $order->id ?>
                </h6>
                <div class="d-md-flex align-items-end gap-3">
                    <div class="d-md-flex align-self-md-center">
                        <p class="fw-bold text-end mb-3 mb-md-0">
                            <i class="fa-solid fa-bullseye text-primary"></i>
                            <?= $order->status == 0 ? "Progressing" : "Shipped" ?>
                        </p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-primary text-white dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Change Status
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="dropdown-item">
                                    <form action="<?= HTTP::link("/admin/change_progressing/") ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $order->id ?>">
                                        <button type="submit" style="all: unset; cursor:pointer;">
                                            Progressing
                                        </button>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item">
                                    <form action="<?= HTTP::link("/admin/change_shipped/") ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $order->id ?>">
                                        <button type="submit" style="all: unset; cursor:pointer;">
                                            Shipped
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
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