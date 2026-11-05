<?php
$pageTitle = 'Home';
$active = 'index';
require __DIR__ . '/includes/header.php';
?>
<div class="card hero">
    <h2>Welcome!</h2>
    <p class="muted">This site demonstrates PHP <code>include</code>/<code>require</code>: every page shares one header and footer.</p>
    <p><a class="btn" href="register.php">Create an account</a> <a class="btn secondary" href="login.php">Login</a></p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
