<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;
use App\Helpers\HTML;

session_start();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
            </ol>
        </nav>
        <div style="max-width: 500px;" class="mx-auto">
            <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
            <div class=" alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            endif;
            unset($_SESSION["error"]);
            ?>
            <form action="<?= HTTP::link("/users/signup") ?>" method="post" enctype="multipart/form-data"
                id="signup-form" class="pt-2 pb-4">
                <div class="mb-3">
                    <label for="image-input" class="form-label">Profile</label><br>
                    <img width="130" height="130" id="image" class="img-fluid img-thumbnail"><br><br>
                    <input class="form-control" type="file" name="profile" id="image-input">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" id="name" placeholder="">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="confirm_password" id="confirm-password"
                        placeholder="Password">
                    <label for="confirm-password">Confirm Password</label>
                </div>
                <div class="mb-4">
                    <p class="small">By creating an account, you agree to our <a href="#"><u>Privacy Policy</u></a> and
                        <a href="#"><u>Terms of Use</u></a>.
                    </p>
                </div>
                <input type="submit" class="btn btn-primary" value="Sign Up">
                <p class="mt-3 text-center small">Already have an account? <a
                        href="<?= HTTP::link("/users/login") ?>"><u>Login</u></a></p>
            </form>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
const imageInput = document.querySelector("#image-input");
const image = document.querySelector("#image");
const signupForm = document.querySelector("#signup-form");
const nameInput = document.querySelector("#name");
const emailInput = document.querySelector("#email");

document.addEventListener("DOMContentLoaded", () => {
    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("signUpValue");
    }

    image.src = "<?= HTML::imgsrc("profiles/default_profile.jpg") ?>";

    imageInput.addEventListener("change", () => {
        if (imageInput.files[0]) {
            const imageReader = new FileReader();
            imageReader.onload = (e) => {
                image.src = e.target.result;
                sessionStorage.setItem("profile", e.target.result);
            }
            imageReader.readAsDataURL(imageInput.files[0]);
        }
    });

    signupForm.addEventListener("submit", () => {
        sessionStorage.setItem("signUpValue", JSON.stringify(
            [nameInput.value, emailInput.value]
        ));
    });

    const [nameValue, emailValue] = JSON.parse(sessionStorage.getItem(
        "signUpValue")) || [];
    nameInput.value = nameValue || "";
    emailInput.value = emailValue || "";
});
</script>