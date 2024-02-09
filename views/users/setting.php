<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\Auth;
use App\Helpers\HTTP;
use App\Helpers\HTML;

$auth = Auth::strictCheck();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
            </ol>
        </nav>
        <?php if (isset($_SESSION["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-info me-2"></i>
            <?= $_SESSION["success"] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        endif;
        unset($_SESSION["success"]);
        ?>
        <div class="d-flex flex-column flex-md-row align-items-start mx-auto pt-3 pb-5" style="max-width: 600px;">
            <div class="nav d-flex flex-row flex-md-column nav-pills mb-3 v-pills-tab mb-md-0" id="v-pills-tab"
                role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                    aria-selected="true" style="width: max-content">Edit Profile</button>
                <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                    aria-selected="false" style="width: max-content">Change Password</button>
            </div>
            <div class="tab-content w-100 ps-md-4" id="v-pills-tabContent">
                <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
                <div class=" alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                endif;
                unset($_SESSION["error"]);
                ?>
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                    aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <form action="<?= HTTP::link("/users/update") ?>" method="post" enctype="multipart/form-data"
                        class="pt-2" id="profile-form">
                        <input type="hidden" name="id" value="<?= $auth->id ?>">
                        <div class="mb-3">
                            <label for="image-input" class="form-label">Profile</label><br>
                            <img src="<?= HTML::imgsrc("profiles/" . $auth->profile) ?>" width="130" height="130"
                                id="image" class="img-fluid img-thumbnail"><br><br>
                            <input class="form-control" type="file" name="profile" id="image-input">
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder=""
                                value="<?= $auth->name ?>">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="name@example.com" value="<?= $auth->email ?>">
                            <label for="email">Email</label>
                        </div>
                        <input type="submit" class="btn btn-primary" name="edit_profile" value="Update Profile">
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab"
                    tabindex="0">
                    <form action="<?= HTTP::link("/users/update") ?>" method="post" id="password-form">
                        <input type="hidden" name="id" value="<?= $auth->id ?>">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password">
                            <label for="password">Old Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="new_password" id="new_password"
                                placeholder="Password">
                            <label for="new_password">New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="confirm_password" id="confirm-password"
                                placeholder="Password">
                            <label for="confirm_password">Confirm New Password</label>
                        </div>
                        <input type="submit" class="btn btn-primary" name="change_password" value="Change Password">
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
const imageInput = document.querySelector("#image-input");
const image = document.querySelector("#image");

document.addEventListener("DOMContentLoaded", () => {
    imageInput.addEventListener("change", () => {
        if (imageInput.files[0]) {
            const imageReader = new FileReader();
            imageReader.onload = (e) => {
                image.src = e.target.result;
            }
            imageReader.readAsDataURL(imageInput.files[0]);
        }
    });
});

document.querySelector("#password-form").addEventListener("submit", function() {
    sessionStorage.setItem("change_password", "true");
});

document.querySelector("#profile-form").addEventListener("submit", function() {
    sessionStorage.setItem("change_password", "false");
});

if (sessionStorage.getItem("change_password") === "true") {
    document.querySelector("#v-pills-password-tab").click();
}
</script>