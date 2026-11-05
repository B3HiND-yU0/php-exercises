<?php
$pageTitle = 'Register';
$active = 'register';
$errors = [];
$old = ['name' => '', 'email' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($old['name'] === '') $errors['name'] = 'Full name is required.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
    if (strlen($pass) < 8) $errors['password'] = 'Password must be at least 8 characters.';
    if ($pass !== $confirm) $errors['confirm_password'] = 'Passwords do not match.';

    $success = empty($errors);
}
require __DIR__ . '/includes/header.php';
?>
<div class="card auth">
    <h2>Register</h2>
    <?php if ($success): ?>
        <div class="alert success">Account created for <?= htmlspecialchars($old['name']) ?>! <a href="login.php">Login now</a>.</div>
    <?php else: ?>
        <form method="post" novalidate>
            <div class="form-group"><label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name']) ?>" required>
                <?php if (isset($errors['name'])): ?><span class="error"><?= $errors['name'] ?></span><?php endif; ?></div>
            <div class="form-group"><label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" required>
                <?php if (isset($errors['email'])): ?><span class="error"><?= $errors['email'] ?></span><?php endif; ?></div>
            <div class="form-group"><label for="password">Password</label>
                <input type="password" id="password" name="password" minlength="8" required>
                <?php if (isset($errors['password'])): ?><span class="error"><?= $errors['password'] ?></span><?php endif; ?></div>
            <div class="form-group"><label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <?php if (isset($errors['confirm_password'])): ?><span class="error"><?= $errors['confirm_password'] ?></span><?php endif; ?></div>
            <button class="btn" type="submit">Register</button>
            <p class="muted">Already have an account? <a href="login.php">Login</a></p>
        </form>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
