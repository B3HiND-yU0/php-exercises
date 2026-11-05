<?php
// PHP Output #1 - Form with validation, appropriate input types and CSS. No database.
require __DIR__ . '/../includes/functions.php';

$data = [];
$errors = [];
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$data, $errors] = validate_person($_POST);
    $submitted = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Output #1</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site"><h1>PHP Output #1</h1></header>
<main>
    <?php if ($submitted): ?>
        <div class="card">
            <h2>Submitted Information</h2>
            <div class="alert success">Form submitted successfully.</div>
            <dl class="result">
                <dt>Full Name</dt><dd><?= e($data['first_name'] . ' ' . $data['last_name']) ?></dd>
                <dt>Age</dt><dd><?= e($data['age']) ?></dd>
                <dt>Gender</dt><dd><?= e($data['gender']) ?></dd>
                <dt>Email</dt><dd><?= e($data['email']) ?></dd>
                <dt>Address</dt><dd><?= nl2br(e($data['address'])) ?></dd>
                <dt>Contact Number</dt><dd><?= e($data['contact_number']) ?></dd>
            </dl>
            <a class="btn secondary" href="index.php">Back to form</a>
        </div>
    <?php else: ?>
        <div class="card">
            <h2>Personal Information</h2>
            <?php if ($errors): ?><div class="alert danger">Please fix the highlighted fields.</div><?php endif; ?>
            <form method="post" action="index.php" novalidate>
                <?php person_fields($data, $errors); ?>
                <button class="btn" type="submit">Submit</button>
                <a class="btn secondary" href="index.php">Reset</a>
            </form>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
