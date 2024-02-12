<?php

use App\Helpers\HTTP;
use App\Helpers\HTML;
use App\Helpers\Auth;

$auth = Auth::check();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<button type="button" class="d-none modal-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="alert alert-success text-center">
            <i class="fa-solid fa-circle-check me-1"></i>
            <?= $_SESSION["success"] ?>
        </div>
    </div>
</div>
<?php if (isset($_SESSION["success"])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".modal-btn").click();
    setTimeout(() => {
        document.querySelector(".btn-close").click();
    }, 1000);
})
</script>
<?php
endif;
unset($_SESSION["success"]);
?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
        <div class="products-heading d-flex justify-content-between mb-3 align-items-center">
            <h4>All Products
                <?= "(" . count($products) . ")" ?>
            </h4>
            <div class="d-flex gap-2">
                <button class="btn btn-primary text-white d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="fa-solid fa-filter"></i>
                </button>
                <div class="offcanvas offcanvas-start px-3 py-2" data-bs-scroll="true" tabindex="-1"
                    id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="by-category">
                            <h6>Category</h6>
                            <ul>
                                <li><a href="<?= HTTP::link("/products/filter?category=1&sortby=default") ?>"
                                        class="<?= isset($_GET["category"]) && $_GET["category"] === "1" ? "fw-bold text-decoration-underline" : "" ?>">Women
                                        Clothing</a></li>
                                <li><a href="<?= HTTP::link("/products/filter?category=2&sortby=default") ?>"
                                        class="<?= isset($_GET["category"]) && $_GET["category"] === "2" ? "fw-bold text-decoration-underline" : "" ?>">Men
                                        Clothing
                                    </a></li>
                                <li><a href="<?= HTTP::link("/products/filter?category=3&sortby=default") ?>"
                                        class="<?= isset($_GET["category"]) && $_GET["category"] === "3" ? "fw-bold text-decoration-underline" : "" ?>">Women
                                        Shoes &
                                        Sandals
                                    </a></li>
                                <li><a href="<?= HTTP::link("/products/filter?category=4&sortby=default") ?>"
                                        class="<?= isset($_GET["category"]) && $_GET["category"] === "4" ? "fw-bold text-decoration-underline" : "" ?>">Men
                                        Shoes &
                                        Sandals
                                    </a></li>
                                <li><a href="<?= HTTP::link("/products/filter?category=5&sortby=default") ?>"
                                        class="<?= isset($_GET["category"]) && $_GET["category"] === "5" ? "fw-bold text-decoration-underline" : "" ?>">Back
                                        Bags
                                    </a></li>
                            </ul>
                        </div>
                        <div class="by-gender mt-4">
                            <h6>Gender</h6>
                            <ul>
                                <li>
                                    <a href="<?= HTTP::link("/products/filter?gender=male&sortby=default") ?>"
                                        class="<?= isset($_GET["gender"]) && $_GET["gender"] === "male" ? "fw-bold text-decoration-underline" : "" ?>">Male
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= HTTP::link("/products/filter?gender=female&sortby=default") ?>"
                                        class="<?= isset($_GET["gender"]) && $_GET["gender"] === "female" ? "fw-bold text-decoration-underline" : "" ?>">Female
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-arrow-down-wide-short"></i>
                        Sort By
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="<?= isset($_GET["sortby"]) && $_GET["sortby"] === "default" ? "dropdown-item fw-bold" : "dropdown-item" ?>"
                                href="<?= HTTP::sortByLink("default") ?>">Default</a></li>
                        <li><a class="<?= isset($_GET["sortby"]) && $_GET["sortby"] === "htol" ? "dropdown-item fw-bold" : "dropdown-item" ?>"
                                href="<?= HTTP::sortByLink("htol") ?>">Price (High to Low)</a></li>
                        <li><a class="<?= isset($_GET["sortby"]) && $_GET["sortby"] === "ltoh" ? "dropdown-item fw-bold" : "dropdown-item" ?>"
                                href="<?= HTTP::sortByLink("ltoh") ?>">Price (Low to High)</a></li>
                        <li><a class="<?= isset($_GET["sortby"]) && $_GET["sortby"] === "alphabetical" ? "dropdown-item fw-bold" : "dropdown-item" ?>"
                                href="<?= HTTP::sortByLink("alphabetical") ?>">Alphabetical [A-Z]</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="products-list row justify-content-center justify-content-md-between pb-5">
            <div class="col-3 filter border border-top-0 border-bottom-0 border-start-0 border-2 d-none d-md-block">
                <div class="by-category">
                    <h6>Category</h6>
                    <ul>
                        <li><a href="<?= HTTP::link("/products/filter?category=1&sortby=default") ?>"
                                class="<?= isset($_GET["category"]) && $_GET["category"] === "1" ? "fw-bold text-decoration-underline" : "" ?>">Women
                                Clothing</a></li>
                        <li><a href="<?= HTTP::link("/products/filter?category=2&sortby=default") ?>"
                                class="<?= isset($_GET["category"]) && $_GET["category"] === "2" ? "fw-bold text-decoration-underline" : "" ?>">Men
                                Clothing
                            </a></li>
                        <li><a href="<?= HTTP::link("/products/filter?category=3&sortby=default") ?>"
                                class="<?= isset($_GET["category"]) && $_GET["category"] === "3" ? "fw-bold text-decoration-underline" : "" ?>">Women
                                Shoes &
                                Sandals
                            </a></li>
                        <li><a href="<?= HTTP::link("/products/filter?category=4&sortby=default") ?>"
                                class="<?= isset($_GET["category"]) && $_GET["category"] === "4" ? "fw-bold text-decoration-underline" : "" ?>">Men
                                Shoes &
                                Sandals
                            </a></li>
                        <li><a href="<?= HTTP::link("/products/filter?category=5&sortby=default") ?>"
                                class="<?= isset($_GET["category"]) && $_GET["category"] === "5" ? "fw-bold text-decoration-underline" : "" ?>">Back
                                Bags
                            </a></li>
                    </ul>
                </div>
                <div class="by-gender mt-4">
                    <h6>Gender</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male2" value="male"
                            <?= isset($_GET["gender"]) && $_GET["gender"] === "male" ? "checked" : "" ?>>
                        <label class="form-check-label" for="male2">
                            <a href="<?= HTTP::link("/products/filter?gender=male&sortby=default") ?>">Male</a>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female2" value="female"
                            <?= isset($_GET["gender"]) && $_GET["gender"] === "female" ? "checked" : "" ?>>
                        <label class="form-check-label" for="female2">
                            <a href="<?= HTTP::link("/products/filter?gender=female&sortby=default") ?>">Female</a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-9 products-items">
                <?php if (count($products) === 0): ?>
                <div class="text-center">
                    <h5>
                        <?= "No results found for \"" . $_GET["search"] . "\"." ?>
                    </h5>
                    <p>
                        Please check the spelling or try again with a more general term.
                    </p>
                </div>
                <?php endif; ?>
                <div class="row row-cols-auto justify-content-evenly justify-content-xl-between g-4">
                    <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card" style="width: 16rem;">
                            <a href="<?= HTTP::link("/products/detail/$product->id") ?>">
                                <img src="<?= HTML::imgsrc("products/" . $product->image) ?>" class="card-img-top"
                                    alt="<?= $product->image ?>">
                            </a>
                            <?php if ($auth): ?>
                            <?php if ($wishlists): ?>
                            <?php foreach ($wishlists as $wishlist): ?>
                            <?php if ($wishlist->product_id == $product->id): ?>
                            <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                                data-userid="<?= $auth->id ?>" data-productid="<?= $product->id ?>"
                                data-status="<?= ($wishlist->status == 1) ? 1 : 0 ?>">
                                <?= ($wishlist->status == 1) ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>' ?>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                                data-userid="<?= $auth->id ?>" data-productid="<?= $product->id ?>" data-status="0">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <?php endif; ?>
                            <?php else: ?>
                            <a href="<?= !$auth ? HTTP::link("/users/login") : '' ?>"
                                onclick="<?= !$auth ? "alert('To do this action, you need to login!')" : '' ?>"
                                class="card-text position-absolute end-0 mt-2 me-3"><i class="fa-regular fa-heart"
                                    style="cursor: default;"></i></a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="<?= HTTP::link("/products/detail/$product->id") ?>">
                                        <?= $product->name ?>
                                    </a>
                                </h6>
                                <p class="card-text">
                                    <?php
                                        if ($product->stock == 0) {
                                            echo "Out of stock";
                                        } else {
                                            echo "(" . $product->stock . " available)";
                                        }
                                        ?>
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
                                <div class="d-flex justify-content-between <?= ($product->stock == 0) ? "d-none" : "" ?> <?php
                                             if (isset($_SESSION["cart"])) {
                                                 foreach ($_SESSION["cart"] as $key => $val) {
                                                     if ($key == $product->id) {
                                                         if ($val["qty"] == $product->stock) {
                                                             echo "d-none";
                                                         }
                                                     }
                                                 }
                                             }
                                             ?>">
                                    <div class="btn-group me-3" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-primary minus "><i
                                                class="fa-solid fa-minus"></i></button>
                                        <button type="button" class="btn btn-outline-primary qty">1</button>
                                        <button type="button" class="btn btn-outline-primary plus"><i
                                                class="fa-solid fa-plus"></i></button>
                                        <p class="product-id d-none">
                                            <?= $product->id ?>
                                        </p>
                                    </div>
                                    <p class="stock d-none">
                                        <?php
                                            if (isset($_SESSION["cart"])) {
                                                foreach ($_SESSION["cart"] as $key => $val) {
                                                    if ($key == $product->id) {
                                                        echo $product->stock - $val["qty"] . ",";
                                                    }
                                                }
                                            }
                                            echo $product->stock;
                                            ?>
                                    </p>
                                    <div class="btn-group add-to-cart-form<?= $product->id ?>">
                                        <button type="button" style="width: 95px" class="btn btn-primary text-white"><i
                                                class="fa-solid fa-cart-plus"></i></button>
                                    </div>
                                    <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        document.querySelector(".add-to-cart-form<?= $product->id ?>")
                                            .addEventListener(
                                                "click",
                                                async () => {
                                                    try {
                                                        const response = await fetch(
                                                            "<?= HTTP::link("/users/cart") ?>", {
                                                                method: "POST",
                                                                headers: {
                                                                    "Content-Type": "application/json",
                                                                },
                                                                body: JSON.stringify({
                                                                    id: <?= $product->id ?>,
                                                                    qty: JSON.parse(
                                                                            sessionStorage
                                                                            .getItem("quantity")
                                                                        ).find(item =>
                                                                            item.id ===
                                                                            <?= $product->id ?>)
                                                                        ?.qty || 1
                                                                }),
                                                            });
                                                    } catch (err) {
                                                        console.log(err);
                                                    }

                                                    sessionStorage.setItem("items", JSON.stringify(
                                                        [
                                                            ...JSON.parse(sessionStorage
                                                                .getItem(
                                                                    "items")),

                                                            {
                                                                id: <?= $product->id ?>,
                                                                qty: JSON.parse(
                                                                        sessionStorage
                                                                        .getItem("quantity")
                                                                    ).find(item =>
                                                                        item.id ===
                                                                        <?= $product->id ?>)
                                                                    ?.qty || 1
                                                            }
                                                        ]
                                                    ));

                                                    location.reload();
                                                });
                                    });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
const plusBtns = document.querySelectorAll(".plus");
const minusBtns = document.querySelectorAll(".minus");

document.addEventListener("DOMContentLoaded", () => {
    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("quantity");
    }

    if (!sessionStorage.getItem("items"))
        sessionStorage.setItem("items", JSON.stringify([]));

    if (!sessionStorage.getItem("quantity"))
        sessionStorage.setItem("quantity", JSON.stringify([]));

    const updateQuantity = (productId, quantity) => {
        const existingQty = JSON.parse(sessionStorage.getItem("quantity"));

        const existingItem = existingQty.find(item => item.id === productId);

        if (existingItem) {
            existingItem.qty = quantity;
        } else {
            existingQty.push({
                id: productId,
                qty: quantity
            });
        }

        sessionStorage.setItem("quantity", JSON.stringify(existingQty));
    }

    plusBtns.forEach(plusBtn => {
        plusBtn.addEventListener("click", () => {
            const stock = plusBtn.parentElement.nextElementSibling.textContent;
            const productId = parseInt(plusBtn.nextElementSibling.textContent);
            const stockVal = stock.split(",")[0] || stock.split(",")[1];

            let quantity = JSON.parse(sessionStorage.getItem("quantity")).find(item =>
                productId === item.id)?.qty || 1;

            if (quantity < stockVal) {
                quantity++;
            }

            plusBtn.previousElementSibling.textContent = quantity;

            updateQuantity(productId, quantity);
        });
    });

    minusBtns.forEach(minusBtn => {
        minusBtn.addEventListener("click", () => {
            const productId = parseInt(minusBtn.nextElementSibling.nextElementSibling
                .nextElementSibling.textContent);
            let quantity = JSON.parse(sessionStorage.getItem("quantity")).find(item =>
                productId === item.id)?.qty || 1;

            if (quantity > 1) {
                quantity--;
            }

            minusBtn.nextElementSibling.textContent = quantity;

            updateQuantity(productId, quantity);
        });
    });
});
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