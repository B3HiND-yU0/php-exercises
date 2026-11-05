<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faculty CRUD | PHP Output #5</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site">
    <h1>PHP Output #5 &mdash; Faculty (MVC)</h1>
    <nav><a href="index.php">Faculty List</a><a href="index.php?action=create">Add Faculty</a></nav>
</header>
<main>
<?php if ($flash): ?><div class="alert <?= e($flash[0]) ?>"><?= e($flash[1]) ?></div><?php endif; ?>
