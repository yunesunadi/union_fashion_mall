<?php

include(__DIR__ . "/components/head.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

?>

<div
    class="d-md-flex justify-content-between mb-3 border-bottom <?= isset($_SESSION["success"]) ? "pt-1 pb-2" : "pt-3 pb-2" ?>">
    <h3 class="h3 mb-3 mb-md-0">
        All Users
        <?= "(" . count($users) . ")" ?>
    </h3>
    <form action="<?= HTTP::link("/admin/search_users/") ?>" class="d-flex mb-2 mb-md-0" role="value">
        <input class="form-control me-2" type="value" placeholder="Search" aria-label="value" name="value">
        <button class="btn btn-primary" style="color: #fff;" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</div>

<?php if (count($users) === 0): ?>
<div class="text-center">
    <h5>
        <?= "No results found for \"" . $_GET["value"] . "\"." ?>
    </h5>
    <p>
        Please check the spelling or try again with a more general term.
    </p>
</div>
<?php else: ?>
<div class="table-responsive mb-3">
    <table class="table" style="width: max-content;">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Profile</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Member Since</th>
                <th scope="col">Order History</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php $count = 1; ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <th scope="row">
                    <?= $count++; ?>
                </th>
                <td>
                    <img src="<?= HTML::imgsrc("profiles/" . $user->profile) ?>" width="80" height="80" id="image"
                        class="img-fluid img-thumbnail">
                </td>
                <td>
                    <?= $user->name ?>
                </td>
                <td>
                    <?= $user->email ?>
                </td>
                <td>
                    <?= $user->created_at ?>
                </td>
                <td class="text-center">
                    <a href="<?= HTTP::link("/admin/view_history/$user->id") ?>">
                        <i class="fa-regular fa-eye"></i> View
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php include(__DIR__ . "/components/foot.php"); ?>