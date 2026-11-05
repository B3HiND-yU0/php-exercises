<?php
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

/** Validate the person form used by Output #1, #3 and #4. Returns [cleanData, errors]. */
function validate_person(array $in): array
{
    $d = [
        'first_name'     => trim($in['first_name'] ?? ''),
        'last_name'      => trim($in['last_name'] ?? ''),
        'age'            => trim($in['age'] ?? ''),
        'gender'         => $in['gender'] ?? '',
        'email'          => trim($in['email'] ?? ''),
        'address'        => trim($in['address'] ?? ''),
        'contact_number' => preg_replace('/[\s-]/', '', trim($in['contact_number'] ?? '')),
    ];
    $err = [];

    foreach (['first_name' => 'First name', 'last_name' => 'Last name'] as $k => $label) {
        if ($d[$k] === '') $err[$k] = "$label is required.";
        elseif (!preg_match("/^[\p{L}][\p{L} .'-]{0,49}$/u", $d[$k])) $err[$k] = "$label may only contain letters, spaces, . ' -";
    }
    if ($d['age'] === '' || !ctype_digit($d['age']) || $d['age'] < 1 || $d['age'] > 120)
        $err['age'] = 'Age must be a whole number from 1 to 120.';
    if (!in_array($d['gender'], ['Male', 'Female', 'Other'], true))
        $err['gender'] = 'Please select a gender.';
    if ($d['email'] === '' || !filter_var($d['email'], FILTER_VALIDATE_EMAIL) || strlen($d['email']) > 100)
        $err['email'] = 'Enter a valid email address.';
    if ($d['address'] === '' || strlen($d['address']) > 255)
        $err['address'] = 'Address is required (max 255 characters).';
    if (!preg_match('/^(09\d{9}|\+639\d{9})$/', $d['contact_number']))
        $err['contact_number'] = 'Use a PH mobile number, e.g. 09123456789 or +639123456789.';

    return [$d, $err];
}

/** Reusable person form fields. $v = values, $err = errors. */
function person_fields(array $v, array $err): void
{
    $f = fn($k) => e($v[$k] ?? '');
    $bad = fn($k) => isset($err[$k]) ? 'invalid' : '';
    $msg = fn($k) => isset($err[$k]) ? '<span class="error">' . e($err[$k]) . '</span>' : '';
    ?>
    <div class="form-row">
        <div class="form-group"><label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="<?= $bad('first_name') ?>" value="<?= $f('first_name') ?>" maxlength="50" required pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ .'\-]*" title="Letters only"><?= $msg('first_name') ?></div>
        <div class="form-group"><label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="<?= $bad('last_name') ?>" value="<?= $f('last_name') ?>" maxlength="50" required pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ .'\-]*" title="Letters only"><?= $msg('last_name') ?></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label for="age">Age</label>
            <input type="number" id="age" name="age" class="<?= $bad('age') ?>" value="<?= $f('age') ?>" min="1" max="120" required><?= $msg('age') ?></div>
        <div class="form-group"><label>Gender</label>
            <div class="radio-group">
                <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                    <label><input type="radio" name="gender" value="<?= $g ?>" <?= ($v['gender'] ?? '') === $g ? 'checked' : '' ?> required> <?= $g ?></label>
                <?php endforeach; ?>
            </div><?= $msg('gender') ?></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label for="email">Email</label>
            <input type="email" id="email" name="email" class="<?= $bad('email') ?>" value="<?= $f('email') ?>" maxlength="100" required><?= $msg('email') ?></div>
        <div class="form-group"><label for="contact_number">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" class="<?= $bad('contact_number') ?>" value="<?= $f('contact_number') ?>" placeholder="09123456789" required pattern="(09\d{9}|\+639\d{9})" title="09XXXXXXXXX or +639XXXXXXXXX"><?= $msg('contact_number') ?></div>
    </div>
    <div class="form-group"><label for="address">Address</label>
        <textarea id="address" name="address" rows="3" class="<?= $bad('address') ?>" maxlength="255" required><?= $f('address') ?></textarea><?= $msg('address') ?></div>
    <?php
}
