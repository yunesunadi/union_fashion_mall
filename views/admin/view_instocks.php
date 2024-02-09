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
    class="d-lg-flex justify-content-between align-items-center mb-3 border-bottom pb-2 pb-md-3 <?= isset($_SESSION["success"]) ? "" : "pt-3" ?>">
    <h3 class="h3 mb-3 mb-lg-0">
        Available Products
        <?= "(" . count($products) . ")" ?>
    </h3>
    <div class="d-md-flex justify-content-between gap-3 align-items-center">
        <form action="<?= HTTP::link("/admin/search_products/") ?>" class="d-flex mb-3 mb-md-0" role="value">
            <input class="form-control me-2" type="value" placeholder="Search" aria-label="value" name="value">
            <button class="btn btn-primary" style="color: #fff;" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        <div class="d-flex">
            <div class="btn-toolbar mb-2 mb-md-0 ms-auto">
                <a href="<?= HTTP::link("/admin/create_product/") ?>" class="btn btn-sm btn-primary text-white">Create
                    Product</a>
            </div>
        </div>
    </div>
</div>

<?php if (count($products) === 0): ?>
<div class="text-center">
    <h5>
        <?= "No results found for \"" . $_GET["value"] . "\"." ?>
    </h5>
    <p>
        Please check the spelling or try again with a more general term.
    </p>
</div>
<?php else: ?>
<div class="table-responsive mb-4">
    <table class="table responsive-table">
        <thead>
            <tr>
                <th scope="col">Code No.</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Details</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($products as $product): ?>
            <tr>
                <th scope="row">
                    <?= $product->code ?>
                </th>
                <td>
                    <img src="<?= HTML::imgsrc("products/" . $product->image) ?>" width="80" height="80" id="image"
                        class="img-fluid img-thumbnail">
                </td>
                <td>
                    <?= $product->name ?>
                </td>
                <td>
                    <?php foreach (explode("|", $product->details) as $detail): ?>
                    <span>
                        <?= $detail ?>
                    </span><br>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?= $product->price ?>Ks
                </td>
                <td>
                    <?= $product->stock ?>
                </td>
                <td>
                    <?php
                            foreach ($categories as $category) {
                                if ($product->category_id == $category->id) {
                                    echo $category->name;
                                }
                            }
                            ?>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="<?= HTTP::link("/admin/update_product/$product->id") ?>">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form action="<?= HTTP::link("/admin/delete_product/") ?>" method="post">
                            <input type="hidden" name="id" value="<?= $product->id ?>">
                            <button type="submit" class="text-primary" style="all: unset; cursor:pointer;">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
sessionStorage.clear();
</script>

<?php include(__DIR__ . "/components/foot.php"); ?>