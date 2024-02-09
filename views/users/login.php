<?php

include(__DIR__ . "/../../vendor/autoload.php");

use App\Helpers\HTTP;

session_start();

include(__DIR__ . "/../components/head.php");
include(__DIR__ . "/../components/nav.php");

?>

<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" class="mt-5 pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= HTTP::link("/") ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
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
        <div style="max-width: 500px;" class="mx-auto">
            <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            endif;
            unset($_SESSION["error"]);
            ?>
            <form action="<?= HTTP::link("/users/login") ?>" method="post" id="login-form" class="pt-2 pb-4">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <input type="submit" class="btn btn-primary" value="Login">
                <p class="mt-3 text-center small">Don't have an account? <a
                        href="<?= HTTP::link("/users/signup") ?>"><u>Sign
                            Up</u></a></p>
            </form>
        </div>
    </div>
</main>

<?php include(__DIR__ . "/../components/footer.php"); ?>
<?php include(__DIR__ . "/../components/foot.php"); ?>

<script>
sessionStorage.removeItem("signUpValue");
</script>