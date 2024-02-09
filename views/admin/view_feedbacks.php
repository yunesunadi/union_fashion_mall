<?php include(__DIR__ . "/components/head.php"); ?>

<div class="mb-3 border-bottom <?= isset($_SESSION["success"]) ? "pt-1 pb-2" : "pt-3 pb-2" ?>">
    <h3 class="h3">
        All Feedbacks
        <?= "(" . count($feedbacks) . ")" ?>
    </h3>
</div>

<div class="row g-3 mb-4 pb-3">
    <?php foreach ($feedbacks as $feedback): ?>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <p class="card-text">Name:
                    <?= $feedback->name ?>
                </p>
                <p class="card-text">Email:
                    <?= $feedback->email ?>
                </p>
                <p class="card-text">Phone No:
                    <?= $feedback->phone_no ?>
                </p>
                <p class="card-text">Subject:
                    <?= $feedback->subject ?>
                </p>
                <p class="card-text">Detailed Message:
                    <?= $feedback->detailed_message ?>
                </p>
                <p class="card-text">Sent at:
                    <?= $feedback->created_at ?>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include(__DIR__ . "/components/foot.php"); ?>