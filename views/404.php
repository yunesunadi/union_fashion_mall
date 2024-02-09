<?php include(__DIR__ . "/../vendor/autoload.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <title>404 | Page not found</title>
</head>

<body>
    <?php include(__DIR__ . "/components/nav.php"); ?>

    <main style="margin-top: 50px; text-align: center; height: 300px; display: grid; place-content: center;">
        <h3 class="mb-3">404 | Page not found</h3>
    </main>

    <?php include(__DIR__ . "/components/footer.php"); ?>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>