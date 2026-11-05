<?php
/** CONTROLLER - handles requests, validation, and picks the view. */
require_once __DIR__ . '/../models/Faculty.php';

class FacultyController
{
    private Faculty $model;

    public function __construct()
    {
        $this->model = new Faculty();
    }

    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');
        $faculty = $this->model->all($search);
        $this->render('index', compact('faculty', 'search'));
    }

    public function create(): void
    {
        $this->render('form', ['mode' => 'create', 'data' => [], 'errors' => []]);
    }

    public function store(): void
    {
        [$data, $errors] = $this->validate($_POST);
        if ($errors) {
            $this->render('form', ['mode' => 'create', 'data' => $data, 'errors' => $errors]);
            return;
        }
        $this->model->create($data);
        $this->redirect('Faculty record added.');
    }

    public function edit(): void
    {
        $row = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$row) { $this->redirect('Record not found.', 'danger'); }
        $this->render('form', ['mode' => 'edit', 'data' => $row, 'errors' => []]);
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if (!$this->model->find($id)) { $this->redirect('Record not found.', 'danger'); }
        [$data, $errors] = $this->validate($_POST);
        if ($errors) {
            $data['id'] = $id;
            $this->render('form', ['mode' => 'edit', 'data' => $data, 'errors' => $errors]);
            return;
        }
        $this->model->update($id, $data);
        $this->redirect('Faculty record updated.');
    }

    public function delete(): void
    {
        $this->model->delete((int)($_POST['id'] ?? 0));
        $this->redirect('Faculty record deleted.');
    }

    /** Server-side validation. Returns [cleanData, errors]. */
    private function validate(array $in): array
    {
        $d = [
            'first_name'  => trim($in['first_name'] ?? ''),
            'middle_name' => trim($in['middle_name'] ?? ''),
            'last_name'   => trim($in['last_name'] ?? ''),
            'age'         => trim($in['age'] ?? ''),
            'gender'      => $in['gender'] ?? '',
            'address'     => trim($in['address'] ?? ''),
            'position'    => trim($in['position'] ?? ''),
            'salary'      => trim($in['salary'] ?? ''),
        ];
        $e = [];
        $nameRx = "/^[\p{L}][\p{L} .'-]{0,49}$/u";

        if ($d['first_name'] === '') $e['first_name'] = 'First name is required.';
        elseif (!preg_match($nameRx, $d['first_name'])) $e['first_name'] = 'Letters, spaces, . \' - only.';
        if ($d['middle_name'] !== '' && !preg_match($nameRx, $d['middle_name'])) $e['middle_name'] = 'Letters, spaces, . \' - only.';
        if ($d['last_name'] === '') $e['last_name'] = 'Last name is required.';
        elseif (!preg_match($nameRx, $d['last_name'])) $e['last_name'] = 'Letters, spaces, . \' - only.';
        if (!ctype_digit($d['age']) || $d['age'] < 18 || $d['age'] > 100) $e['age'] = 'Age must be a whole number from 18 to 100.';
        if (!in_array($d['gender'], ['Male', 'Female', 'Other'], true)) $e['gender'] = 'Please select a gender.';
        if ($d['address'] === '' || strlen($d['address']) > 255) $e['address'] = 'Address is required (max 255 characters).';
        if ($d['position'] === '' || strlen($d['position']) > 100) $e['position'] = 'Position is required (max 100 characters).';
        if (!is_numeric($d['salary']) || $d['salary'] < 0 || $d['salary'] > 9999999999.99) $e['salary'] = 'Enter a valid salary (0 or more).';
        else $d['salary'] = number_format((float)$d['salary'], 2, '.', '');

        return [$d, $e];
    }

    private function render(string $view, array $vars = []): void
    {
        extract($vars);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/faculty/' . $view . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    private function redirect(string $msg, string $type = 'success'): void
    {
        $_SESSION['flash'] = [$type, $msg];
        header('Location: index.php');
        exit;
    }
}
