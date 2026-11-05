<?php
/** FRONT CONTROLLER / ROUTER - every request enters here: index.php?action=... */
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/controllers/FacultyController.php';

$action = $_GET['action'] ?? 'index';
$postOnly = ['store', 'update', 'delete'];
$allowed = ['index', 'create', 'store', 'edit', 'update', 'delete'];

if (!in_array($action, $allowed, true)) $action = 'index';
if (in_array($action, $postOnly, true) && $_SERVER['REQUEST_METHOD'] !== 'POST') $action = 'index';

try {
    (new FacultyController())->$action();
} catch (PDOException $ex) {
    require __DIR__ . '/views/layout/header.php';
    echo '<div class="alert danger">Database error: ' . e($ex->getMessage()) . '</div>';
    require __DIR__ . '/views/layout/footer.php';
}
