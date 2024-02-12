<?php

use App\Helpers\HTTP;
use App\Helpers\HTML;
use App\Helpers\Auth;

$auth = Auth::check();

?>

<link rel="stylesheet" href="./../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="./../../node_modules/@flaticon/flaticon-uicons/css/all/all.css">
<link rel="stylesheet" href="./../../node_modules/@splidejs/splide/dist/css/splide.min.css">
<link rel="stylesheet" href="./../../assets/css/custom.css">

<?php include(__DIR__ . "/../components/nav.php"); ?>

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
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/products/") ?>">Products</a>
                <li class="breadcrumb-item">
                    <a href="<?= HTTP::link("/products/filter?category=$product->category_id&sortby=default") ?>">
                        <?php
                        foreach ($categories as $category) {
                            if ($product->category_id == $category->id) {
                                echo $category->name;
                            }
                        }
                        ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $product->name ?>
                </li>
            </ol>
        </nav>
        <div class="row justify-content-center g-md-5 pt-3 pb-5">
            <div class="col-sm-6 mb-4 mb-md-0">
                <img src="<?= HTML::imgsrc("products/" . $product->image) ?>" id="image"
                    class="img-fluid img-thumbnail">
            </div>
            <div class="col-sm-6">
                <h5 class="text-primary">
                    <?= $product->name ?>
                </h5>
                <p>
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
                    <span class="me-2">
                        <?= $product->price ?> Ks
                    </span>
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
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="<?= ($product->stock == 0) ? "d-none" : ""; ?> <?php
                             if (isset($_SESSION["cart"])) {
                                 foreach ($_SESSION["cart"] as $key => $val) {
                                     if ($key == $product->id) {
                                         if ($val["qty"] == $product->stock) {
                                             echo "d-none";
                                         }
                                     }
                                 }
                             }
                             ?> btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn btn-outline-primary minus"><i
                                class="fa-solid fa-minus"></i></button>
                        <button type="button" class="btn btn-outline-primary qty">1</button>
                        <button type="button" class="btn btn-outline-primary plus"><i
                                class="fa-solid fa-plus"></i></button>
                        <p class="product-id d-none">
                            <?= $product->id ?>
                        </p>
                    </div>
                    <p class="card-text">
                        <?php
                        if ($product->stock == 0) {
                            echo "Out of stock";
                        } else {
                            echo "(" . $product->stock . " available)";
                        }
                        ?>
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
                <?php foreach (explode("|", $product->details) as $detail): ?>
                <span>
                    <?= $detail ?>
                </span><br>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between gap-3 mt-4 w-75">
                    <div class="<?= ($product->stock == 0) ? "d-none" : ""; ?> <?php
                             if (isset($_SESSION["cart"])) {
                                 foreach ($_SESSION["cart"] as $key => $val) {
                                     if ($key == $product->id) {
                                         if ($val["qty"] == $product->stock) {
                                             echo "d-none";
                                         }
                                     }
                                 }
                             }
                             ?> btn-group w-100 add-to-cart-form<?= $product->id ?>">
                        <button type="button" style="width: 95px" class="btn btn-primary text-white "><i
                                class="fa-solid fa-cart-plus me-2"></i> Add to Cart</button>
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
                                                            .getItem("detailQuantity")
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
                                                        .getItem("detailQuantity")
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
                    <?php if ($auth): ?>
                    <?php if ($wishlists): ?>
                    <?php foreach ($wishlists as $wishlist): ?>
                    <?php if ($wishlist->product_id == $product->id): ?>
                    <a class="wishlist-btn btn btn-primary text-white" data-userid="<?= $auth->id ?>"
                        data-productid="<?= $product->id ?>" data-status="<?= ($wishlist->status == 1) ? 1 : 0 ?>">
                        <?= ($wishlist->status == 1) ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>' ?>
                    </a>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <a class="wishlist-btn btn btn-primary text-white" data-userid="<?= $auth->id ?>"
                        data-productid="<?= $product->id ?>" data-status="0">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                    <?php endif; ?>
                    <?php else: ?>
                    <a href="<?= !$auth ? HTTP::link("/users/login") : '' ?>"
                        onclick="<?= !$auth ? "alert('To do this action, you need to login!')" : '' ?>"
                        class="btn btn-primary text-white"><i class="fa-regular fa-heart"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        $filter_products = [];
        $count = 0;
        foreach ($products as $p) {
            if ($p->category_id == $product->category_id && $p->id != $product->id) {
                $filter_products[] = $p;
                $count++;

                if ($count >= 5)
                    break;
            }
        }
        ?>
        <div class="splide mb-4">
            <h6 class="mb-4 text-primary fw-semibold">Related Products</h6>
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($filter_products as $filter_product): ?>
                    <li class="splide__slide">
                        <div class="card" style="width: 18rem;">
                            <a href="<?= HTTP::link("/products/detail/$filter_product->id") ?>">
                                <img src="<?= HTML::imgsrc("products/" . $filter_product->image) ?>"
                                    class="card-img-top" alt="<?= $filter_product->image ?>">
                            </a>
                            <?php if ($auth): ?>
                            <?php if ($wishlists): ?>
                            <?php foreach ($wishlists as $wishlist): ?>
                            <?php if ($wishlist->product_id == $filter_product->id): ?>
                            <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                                data-userid="<?= $auth->id ?>" data-productid="<?= $filter_product->id ?>"
                                data-status="<?= ($wishlist->status == 1) ? 1 : 0 ?>">
                                <?= ($wishlist->status == 1) ? '<i class="fa-solid fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>' ?>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <a class="wishlist-btn card-text position-absolute end-0 mt-2 me-3"
                                data-userid="<?= $auth->id ?>" data-productid="<?= $filter_product->id ?>"
                                data-status="0">
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
                                    <a href="<?= HTTP::link("/products/detail/$filter_product->id") ?>">
                                        <?= $filter_product->name ?>
                                    </a>
                                </h6>
                                <p class="card-text">
                                    <?= $filter_product->price ?> Ks
                                </p>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>

<script src="./../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
const plusBtns = document.querySelectorAll(".plus");
const minusBtns = document.querySelectorAll(".minus");

document.addEventListener("DOMContentLoaded", () => {
    const redirectedUrl = window.location.href;

    if (window.location.href.includes(redirectedUrl)) {
        if (!sessionStorage.getItem("pageReloaded<?= $product->id ?>")) {
            sessionStorage.setItem("pageReloaded<?= $product->id ?>", "true");
            setTimeout(function() {
                window.location.reload();
            }, 100);
        }
    }

    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("detailQuantity");
    }

    if (!sessionStorage.getItem("items"))
        sessionStorage.setItem("items", JSON.stringify([]));

    if (!sessionStorage.getItem("detailQuantity"))
        sessionStorage.setItem("detailQuantity", JSON.stringify([]));

    const updateQuantity = (productId, quantity) => {
        const existingQty = JSON.parse(sessionStorage.getItem("detailQuantity"));

        const existingItem = existingQty.find(item => item.id === productId);

        if (existingItem) {
            existingItem.qty = quantity;
        } else {
            existingQty.push({
                id: productId,
                qty: quantity
            });
        }

        sessionStorage.setItem("detailQuantity", JSON.stringify(existingQty));
    }

    plusBtns.forEach(plusBtn => {
        plusBtn.addEventListener("click", () => {
            const stock = plusBtn.parentElement.parentElement.nextElementSibling.textContent;
            const productId = parseInt(plusBtn.nextElementSibling.textContent);
            const stockVal = stock.split(",")[0] || stock.split(",")[1];

            let quantity = JSON.parse(sessionStorage.getItem("detailQuantity")).find(item =>
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
            let quantity = JSON.parse(sessionStorage.getItem("detailQuantity")).find(item =>
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

<script src="./../../node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    new Splide(".splide", {
        type: "loop",
        focus: "center",
        padding: "0rem",
        perPage: 4,
        perMove: 1,
        height: "27rem",
        breakpoints: {
            780: {
                perPage: 1,
            },
            1200: {
                perPage: 2,
            },
            1400: {
                perPage: 3,
            },
        },
    }).mount();
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