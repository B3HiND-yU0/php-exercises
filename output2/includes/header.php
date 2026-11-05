<?php
// Shared header + navigation. Set $pageTitle and $active before including.
$pageTitle = $pageTitle ?? 'My Website';
$active = $active ?? '';
$links = ['index' => 'Home', 'register' => 'Register', 'login' => 'Login', 'forgot-password' => 'Forgot Password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> | PHP Output #2</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site">
    <h1>PHP Output #2</h1>
    <nav>
        <?php foreach ($links as $file => $label): ?>
            <a href="<?= $file ?>.php" class="<?= $active === $file ? 'active' : '' ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>
</header>
<main>
