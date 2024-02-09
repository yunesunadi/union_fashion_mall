<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;
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
                <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
            </ol>
        </nav>
        <div class="mt-4 mb-5">
            <h5 class="mb-3">
                My Wishlist
                <?php
                if (count($products) != 0) {
                    echo " (" . count($products) . ")";
                }
                ?>
            </h5>
            <?php if (count($products) == 0): ?>
            <div class="info text-center my-5 py-5">
                <h5 class="mb-3">There is no items in your wishlist.</h5>
                <a href="<?= HTTP::link("/products/") ?>" class="btn btn-primary">Continue Shopping</a>
            </div>
            <?php else: ?>
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <a href="<?= HTTP::link("/products/detail/$product->id") ?>">
                            <img src="<?= HTML::imgsrc("products/" . $product->image) ?>" class="card-img-top"
                                alt="<?= $product->image ?>">
                        </a>
                        <?php if ($wishlists): ?>
                        <?php foreach ($wishlists as $wishlist): ?>
                        <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                            data-userid="<?= $auth->id ?>" data-productid="<?= $product->id ?>"
                            data-status="<?= (($wishlist->product_id == $product->id) && ($wishlist->status == 1)) ? 1 : 0 ?>">
                            <?= (($wishlist->product_id == $product->id) && ($wishlist->status == 1)) ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>' ?>
                        </a>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                            data-userid="<?= $auth->id ?>" data-productid="<?= $product->id ?>" data-status="1">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="<?= HTTP::link("/products/detail/$product->id") ?>">
                                    <?= $product->name ?>
                                </a>
                            </h6>
                            <p class="card-text">
                                <a href="<?= HTTP::link("/products/filter?category=$product->category_id&sortby=default") ?>"
                                    class="text-dark">
                                    <?php
                                            foreach ($categories as $category) {
                                                if ($product->category_id == $category->id) {
                                                    echo $category->name;
                                                }
                                            }
                                            ?>
                                </a>
                            </p>
                            <p class="card-text">
                                <?= $product->price ?> Ks
                                <?php
                                        if (isset($_SESSION["cart"])) {
                                            foreach ($_SESSION["cart"] as $key => $val) {
                                                if ($key == $product->id) {
                                                    echo " (" . $val["qty"] . " items in cart)";
                                                }
                                            }
                                        }
                                        ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

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