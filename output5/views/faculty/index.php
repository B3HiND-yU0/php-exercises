<div class="card">
    <div class="toolbar">
        <h2 style="margin:0">Faculty Members (<?= count($faculty) ?>)</h2>
        <form method="get" action="index.php">
            <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search name or position">
            <button class="btn sm" type="submit">Search</button>
            <?php if ($search !== ''): ?><a class="btn sm secondary" href="index.php">Clear</a><?php endif; ?>
            <a class="btn sm" href="index.php?action=create">+ Add</a>
        </form>
    </div>
    <div class="table-wrap">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Address</th><th>Position</th><th>Salary</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if (!$faculty): ?><tr><td colspan="8" class="muted">No faculty records found.</td></tr><?php endif; ?>
        <?php foreach ($faculty as $f): ?>
            <tr>
                <td><?= (int)$f['id'] ?></td>
                <td><?= e(trim($f['first_name'] . ' ' . ($f['middle_name'] ?? '') . ' ' . $f['last_name'])) ?></td>
                <td><?= (int)$f['age'] ?></td>
                <td><?= e($f['gender']) ?></td>
                <td><?= e($f['address']) ?></td>
                <td><?= e($f['position']) ?></td>
                <td>&#8369;<?= number_format((float)$f['salary'], 2) ?></td>
                <td class="actions">
                    <a class="btn sm" href="index.php?action=edit&id=<?= (int)$f['id'] ?>">Edit</a>
                    <form method="post" action="index.php?action=delete" onsubmit="return confirm('Delete this faculty record?');">
                        <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                        <button class="btn sm danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
