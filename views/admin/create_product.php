<?php

include(__DIR__ . "/components/head.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

?>

<?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
<div class="alert alert-warning alert-dismissible fade show mt-3 mb-0" role="alert">
    <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
endif;
unset($_SESSION["error"]);
?>

<div
    class="mb-3 border-bottom <?= isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0 ? "pb-2" : "pt-3 pb-2" ?>">
    <h3 class="h3">New Product</h3>
</div>

<form action="<?= HTTP::link("/admin/create_product") ?>" method="post" enctype="multipart/form-data" id="create-form"
    style="max-width: 500px;" class="mb-5">
    <div class=" mb-3">
        <label for="image-input" class="form-label">Image</label><br>
        <img width="130" height="130" id="image" class="img-fluid img-thumbnail"><br><br>
        <input class="form-control" type="file" name="image" id="image-input">
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="code" id="code" placeholder="">
        <label for="code">Code No.</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="name" id="name" placeholder="">
        <label for="name">Name</label>
    </div>
    <div class="mb-3">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="details" style="height: 150px"
                name="details"></textarea>
            <label for="details">Details</label>
        </div>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="price" id="price" placeholder="">
        <label for="price">Price</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" name="stock" id="stock" min="1" placeholder="">
        <label for="stock">No. of stocks</label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" name="category_id" id="category_id" aria-label="Default select example">
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category->id ?>">
                <?= $category->name ?>
            </option>
            <?php endforeach; ?>
        </select>
        <label for="category_id">Category</label>
    </div>
    <button type="submit" class="btn btn-primary text-white">Create</button>
</form>

<script>
const imageInput = document.querySelector("#image-input");
const image = document.querySelector("#image");
const createForm = document.querySelector("#create-form");
const codeInput = document.querySelector("#code");
const nameInput = document.querySelector("#name");
const detailsInput = document.querySelector("#details");
const priceInput = document.querySelector("#price");
const stockInput = document.querySelector("#stock");
const categoryIdInput = document.querySelector("#category_id");

document.addEventListener("DOMContentLoaded", () => {
    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("createValue");
    }

    image.src = "<?= HTML::imgsrc("products/default_product.png") ?>";

    imageInput.addEventListener("change", () => {
        if (imageInput.files[0]) {
            const imageReader = new FileReader();
            imageReader.onload = (e) => {
                image.src = e.target.result;
                sessionStorage.setItem("image", e.target.result);
            }
            imageReader.readAsDataURL(imageInput.files[0]);
        }
    });

    createForm.addEventListener("submit", () => {
        sessionStorage.setItem("createValue", JSON.stringify([codeInput.value, nameInput.value,
            detailsInput.value, priceInput.value, stockInput.value, categoryIdInput.value
        ]));
    });

    const [codeValue, nameValue, detailsValue, priceValue, stockValue, categoryIdValue] = JSON.parse(
        sessionStorage.getItem(
            "createValue")) || [];
    codeInput.value = codeValue || "";
    nameInput.value = nameValue || "";
    detailsInput.value = detailsValue || "";
    priceInput.value = priceValue || "";
    stockInput.value = stockValue || "";
    categoryIdInput.value = categoryIdValue || "";
});
</script>

<?php include(__DIR__ . "/components/foot.php"); ?>