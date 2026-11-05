<?php
$isEdit = $mode === 'edit';
$f = fn($k) => e($data[$k] ?? '');
$bad = fn($k) => isset($errors[$k]) ? 'invalid' : '';
$msg = fn($k) => isset($errors[$k]) ? '<span class="error">' . e($errors[$k]) . '</span>' : '';
?>
<div class="card">
    <h2><?= $isEdit ? 'Edit Faculty #' . (int)$data['id'] : 'Add Faculty' ?></h2>
    <?php if ($errors): ?><div class="alert danger">Please fix the highlighted fields.</div><?php endif; ?>
    <form method="post" action="index.php?action=<?= $isEdit ? 'update' : 'store' ?>" novalidate>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int)$data['id'] ?>"><?php endif; ?>

        <div class="form-row">
            <div class="form-group"><label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="<?= $bad('first_name') ?>" value="<?= $f('first_name') ?>" maxlength="50" required><?= $msg('first_name') ?></div>
            <div class="form-group"><label for="middle_name">Middle Name <span class="muted">(optional)</span></label>
                <input type="text" id="middle_name" name="middle_name" class="<?= $bad('middle_name') ?>" value="<?= $f('middle_name') ?>" maxlength="50"><?= $msg('middle_name') ?></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="<?= $bad('last_name') ?>" value="<?= $f('last_name') ?>" maxlength="50" required><?= $msg('last_name') ?></div>
            <div class="form-group"><label for="age">Age</label>
                <input type="number" id="age" name="age" class="<?= $bad('age') ?>" value="<?= $f('age') ?>" min="18" max="100" required><?= $msg('age') ?></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label for="gender">Gender</label>
                <select id="gender" name="gender" class="<?= $bad('gender') ?>" required>
                    <option value="">-- Select --</option>
                    <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                        <option value="<?= $g ?>" <?= ($data['gender'] ?? '') === $g ? 'selected' : '' ?>><?= $g ?></option>
                    <?php endforeach; ?>
                </select><?= $msg('gender') ?></div>
            <div class="form-group"><label for="position">Position</label>
                <input type="text" id="position" name="position" class="<?= $bad('position') ?>" value="<?= $f('position') ?>" maxlength="100" required><?= $msg('position') ?></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label for="salary">Salary (&#8369;)</label>
                <input type="number" id="salary" name="salary" class="<?= $bad('salary') ?>" value="<?= $f('salary') ?>" min="0" step="0.01" required><?= $msg('salary') ?></div>
            <div class="form-group"><label for="address">Address</label>
                <input type="text" id="address" name="address" class="<?= $bad('address') ?>" value="<?= $f('address') ?>" maxlength="255" required><?= $msg('address') ?></div>
        </div>

        <button class="btn" type="submit"><?= $isEdit ? 'Update' : 'Save' ?></button>
        <a class="btn secondary" href="index.php">Cancel</a>
    </form>
</div>
