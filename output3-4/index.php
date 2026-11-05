<?php
// PHP Output #3 and #4 - Form saved to MySQL + list of registered persons (search, edit, delete).
session_start();
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../includes/functions.php';

$errors = [];
$old = [];
$editId = null;
$dbError = '';

try {
    $pdo = Database::getConnection();

    // ---- DELETE ----
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM registered_persons WHERE id = ?');
        $stmt->execute([(int)($_POST['id'] ?? 0)]);
        $_SESSION['flash'] = ['success', 'Record deleted.'];
        header('Location: index.php');
        exit;
    }

    // ---- INSERT / UPDATE ----
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($_POST['action'] ?? '', ['create', 'update'], true)) {
        [$old, $errors] = validate_person($_POST);
        $isUpdate = $_POST['action'] === 'update';
        $id = (int)($_POST['id'] ?? 0);

        if (!$errors) {
            // Email must be unique
            $check = $pdo->prepare('SELECT id FROM registered_persons WHERE email = ? AND id <> ?');
            $check->execute([$old['email'], $isUpdate ? $id : 0]);
            if ($check->fetch()) $errors['email'] = 'This email is already registered.';
        }

        if (!$errors) {
            $params = [$old['first_name'], $old['last_name'], (int)$old['age'], $old['gender'],
                       $old['email'], $old['address'], $old['contact_number']];
            if ($isUpdate) {
                $sql = 'UPDATE registered_persons SET first_name=?, last_name=?, age=?, gender=?, email=?, address=?, contact_number=? WHERE id=?';
                $params[] = $id;
                $msg = 'Record updated successfully.';
            } else {
                $sql = 'INSERT INTO registered_persons (first_name, last_name, age, gender, email, address, contact_number) VALUES (?,?,?,?,?,?,?)';
                $msg = 'Record saved successfully.';
            }
            $pdo->prepare($sql)->execute($params);
            $_SESSION['flash'] = ['success', $msg];
            header('Location: index.php');
            exit;
        }
        if ($isUpdate) $editId = $id;
    }

    // ---- LOAD RECORD FOR EDIT ----
    if (isset($_GET['edit']) && !$_POST) {
        $stmt = $pdo->prepare('SELECT * FROM registered_persons WHERE id = ?');
        $stmt->execute([(int)$_GET['edit']]);
        if ($row = $stmt->fetch()) { $old = $row; $editId = (int)$row['id']; }
    }

    // ---- LIST (with search) ----
    $search = trim($_GET['q'] ?? '');
    if ($search !== '') {
        $like = '%' . $search . '%';
        $stmt = $pdo->prepare('SELECT * FROM registered_persons WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR address LIKE ? ORDER BY id DESC');
        $stmt->execute([$like, $like, $like, $like]);
    } else {
        $stmt = $pdo->query('SELECT * FROM registered_persons ORDER BY id DESC');
    }
    $persons = $stmt->fetchAll();
} catch (PDOException $ex) {
    $dbError = 'Database error: ' . $ex->getMessage();
    $persons = [];
    $search = '';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Output #3 and #4</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site"><h1>PHP Output #3 and #4</h1></header>
<main>
    <?php if ($dbError): ?><div class="alert danger"><?= e($dbError) ?></div><?php endif; ?>
    <?php if ($flash): ?><div class="alert <?= e($flash[0]) ?>"><?= e($flash[1]) ?></div><?php endif; ?>

    <div class="card">
        <h2><?= $editId ? 'Edit Record #' . (int)$editId : 'Register a Person' ?></h2>
        <form method="post" action="index.php" novalidate>
            <input type="hidden" name="action" value="<?= $editId ? 'update' : 'create' ?>">
            <?php if ($editId): ?><input type="hidden" name="id" value="<?= (int)$editId ?>"><?php endif; ?>
            <?php person_fields($old, $errors); ?>
            <button class="btn" type="submit"><?= $editId ? 'Update' : 'Save' ?></button>
            <?php if ($editId): ?><a class="btn secondary" href="index.php">Cancel</a><?php endif; ?>
        </form>
    </div>

    <div class="card">
        <div class="toolbar">
            <h2 style="margin:0">List of Registered Persons (<?= count($persons) ?>)</h2>
            <form method="get" action="index.php">
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search name, email, address">
                <button class="btn sm" type="submit">Search</button>
                <?php if ($search !== ''): ?><a class="btn sm secondary" href="index.php">Clear</a><?php endif; ?>
            </form>
        </div>
        <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Name</th><th>Age</th><th>Gender</th><th>Email</th><th>Address</th><th>Contact</th><th>Actions</th></tr></thead>
            <tbody>
            <?php if (!$persons): ?>
                <tr><td colspan="8" class="muted">No records found.</td></tr>
            <?php endif; ?>
            <?php foreach ($persons as $p): ?>
                <tr>
                    <td><?= (int)$p['id'] ?></td>
                    <td><?= e($p['first_name'] . ' ' . $p['last_name']) ?></td>
                    <td><?= (int)$p['age'] ?></td>
                    <td><?= e($p['gender']) ?></td>
                    <td><?= e($p['email']) ?></td>
                    <td><?= e($p['address']) ?></td>
                    <td><?= e($p['contact_number']) ?></td>
                    <td class="actions">
                        <a class="btn sm" href="index.php?edit=<?= (int)$p['id'] ?>">Edit</a>
                        <form method="post" action="index.php" onsubmit="return confirm('Delete this record?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <button class="btn sm danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</main>
</body>
</html>
