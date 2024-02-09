<?php

include(__DIR__ . "/components/head.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

?>

<div class="d-md-flex justify-content-between align-items-center mb-3 border-bottom pt-3 pb-2 pb-md-3">
    <h3 class="h3 mb-3 mb-md-0">
        Soldout Products
        <?= "(" . count($soldouts) . ")" ?>
    </h3>
    <form action="<?= HTTP::link("/admin/search_soldouts/") ?>" class="d-flex mb-3 mb-md-0" role="value">
        <input class="form-control me-2" type="value" placeholder="Search" aria-label="value" name="value">
        <button class="btn btn-primary" style="color: #fff;" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</div>

<?php if (count($soldouts) === 0): ?>
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
            <?php foreach ($soldouts as $product): ?>
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
                        <form action="<?= HTTP::link("/admin/delete_product/") ?>" method=" post">
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

<?php include(__DIR__ . "/components/foot.php"); ?>