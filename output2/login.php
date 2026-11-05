<?php
$pageTitle = 'Login';
$active = 'login';
$error = '';
$email = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === '') {
        $error = 'Please enter a valid email and password.';
    } else {
        // Output #2 has no database, so any well-formed credentials are accepted for the demo.
        $success = true;
    }
}
require __DIR__ . '/includes/header.php';
?>
<div class="card auth">
    <h2>Login</h2>
    <?php if ($success): ?>
        <div class="alert success">Welcome back, <?= htmlspecialchars($email) ?>!</div>
        <a class="btn secondary" href="index.php">Go to Home</a>
    <?php else: ?>
        <?php if ($error): ?><div class="alert danger"><?= $error ?></div><?php endif; ?>
        <form method="post" novalidate>
            <div class="form-group"><label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required></div>
            <div class="form-group"><label for="password">Password</label>
                <input type="password" id="password" name="password" required></div>
            <button class="btn" type="submit">Login</button>
            <p class="muted"><a href="forgot-password.php">Forgot password?</a> &middot; <a href="register.php">Register</a></p>
        </form>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
