<?php
$pageTitle = 'Forgot Password';
$active = 'forgot-password';
$error = '';
$email = '';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Enter a valid email address.';
    else $sent = true;
}
require __DIR__ . '/includes/header.php';
?>
<div class="card auth">
    <h2>Forgot Password</h2>
    <?php if ($sent): ?>
        <div class="alert success">If an account exists for <?= htmlspecialchars($email) ?>, a reset link has been sent.</div>
        <a class="btn secondary" href="login.php">Back to Login</a>
    <?php else: ?>
        <p class="muted">Enter your email and we'll send you a link to reset your password.</p>
        <?php if ($error): ?><div class="alert danger"><?= $error ?></div><?php endif; ?>
        <form method="post" novalidate>
            <div class="form-group"><label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required></div>
            <button class="btn" type="submit">Send Reset Link</button>
        </form>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
