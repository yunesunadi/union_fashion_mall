<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;
use App\Helpers\Auth;

Auth::check();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Cart</li>
            </ol>
        </nav>
        <?php if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0): ?>
        <div class="info text-center my-5 py-5">
            <h5 class="mb-3">There is no items in your cart.</h5>
            <a href="<?= HTTP::link("/products/") ?>" class="btn btn-primary">Continue Shopping</a>
        </div>
        <?php else: ?>
        <div class="row my-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-primary">My Cart</h5>
                    <a href="<?= HTTP::link("/users/remove_cart") ?>">
                        <i class="fa-regular fa-circle-xmark"></i> Clear All
                    </a>
                </div>
                <div class="table-responsive mb-4 mb-lg-0">
                    <?php
                        $total_items = 0;
                        $total_price = 0;
                        foreach ($_SESSION["cart"] as $cart) {
                            $total_items += (int) $cart["qty"];
                        }
                        foreach ($_SESSION["cart"] as $cart) {
                            $total_price += $cart["price"] * (int) $cart["qty"];
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
                            <?php foreach ($_SESSION["cart"] as $product): ?>
                            <tr>
                                <th scope="row">
                                    <?= $product["code"] ?>
                                </th>
                                <td class="d-flex align-items-center">
                                    <img src="<?= HTML::imgsrc("products/" . $product["image"]) ?>" width="80"
                                        height="80" id="image" class="img-fluid img-thumbnail">
                                    <div class="ms-3">
                                        <a href="<?= HTTP::link("/products/detail/" . $product["id"]) ?>">
                                            <?= $product["name"] ?>
                                        </a><br>
                                        <a href="<?= HTTP::link("/products/filter?category=" . $product["category_id"] . "&sortby=default") ?>"
                                            class="text-dark">
                                            <small>
                                                <?php
                                                        foreach ($categories as $category) {
                                                            if ($product["category_id"] == $category->id) {
                                                                echo $category->name;
                                                            }
                                                        }
                                                        ?>
                                            </small>
                                        </a>
                                        <br>
                                        <?php if ($auth): ?>
                                        <?php if ($wishlists): ?>
                                        <?php foreach ($wishlists as $wishlist): ?>
                                        <?php if ($wishlist->product_id == $product["id"]): ?>
                                        <a class="wishlist-btn" data-userid="<?= $auth->id ?>"
                                            data-productid="<?= $product["id"] ?>"
                                            data-status="<?= ($wishlist->status == 1) ? 1 : 0 ?>">
                                            <?= ($wishlist->status == 1) ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>' ?>
                                        </a>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <a class="wishlist-btn" data-userid="<?= $auth->id ?>"
                                            data-productid="<?= $product["id"] ?>" data-status="0">
                                            <i class="fa-regular fa-heart"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <a href="<?= !$auth ? HTTP::link("/users/login") : '' ?>"
                                            onclick="<?= !$auth ? "alert('To do this action, you need to login!')" : '' ?>"><i
                                                class="fa-regular fa-heart"></i></a>
                                        <?php endif; ?>
                                        <a class="remove-btn ms-2" data-id="<?= $product["id"] ?>"
                                            style="cursor: pointer;"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <?= $product["price"] ?>Ks
                                </td>
                                <td>
                                    <?= $product["qty"] ?>
                                </td>
                                <td>
                                    <?= $product["price"] * $product["qty"] ?>Ks
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Sub Total:
                                    <?= $total_price ?>Ks
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
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
                        <a href="<?= $auth ? HTTP::link("/users/checkout") : HTTP::link("/users/login") ?>"
                            onclick="<?= !$auth ? "alert('To do this action, you need to login!')" : '' ?>"
                            class="btn btn-primary mt-3 w-100 text-white">Checkout</a>
                    </div>
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
const removeBtns = document.querySelectorAll(".remove-btn");

document.addEventListener("DOMContentLoaded", () => {
    removeBtns.forEach(removeBtn => {
        removeBtn.addEventListener("click", async () => {
            try {
                const response = await fetch(
                    `${window.location.origin}<?= HTTP::link("/users/remove_cart_item") ?>`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            id: removeBtn.dataset.id
                        }),
                    });

                if (response.status === 200) {
                    location.reload();
                }
            } catch (err) {
                console.log(err);
            }
        })
    })
})
</script>

<script>
const wishlistBtns = document.querySelectorAll(".wishlist-btn");

wishlistBtns.forEach((wishlistBtn) => {
    const userId = wishlistBtn.dataset.userid;
    const productId = wishlistBtn.dataset.productid;

    wishlistBtn.addEventListener("click", async () => {
        const newStatus = wishlistBtn.dataset.status == 1 ? 0 : 1;
        wishlistBtn.dataset.status = newStatus;

        try {
            const requestInfo = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    user_id: userId,
                    product_id: productId,
                    status: newStatus
                }),
            };
            const response = await fetch("<?= HTTP::link("/users/wishlist") ?>", requestInfo);

            if (response.status === 200) {
                wishlistBtn.innerHTML = wishlistBtn.dataset.status == 1 ?
                    '<i class="fa-solid fa-heart"></i>' :
                    '<i class="fa-regular fa-heart"></i>';
            }
        } catch (err) {
            console.log(err);
        }
    });
});
</script>