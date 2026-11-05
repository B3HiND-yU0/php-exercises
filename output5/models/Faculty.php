<?php
/** MODEL - all database access for the faculty table. */
require_once __DIR__ . '/../config/database.php';

class Faculty
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(string $search = ''): array
    {
        if ($search !== '') {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare('SELECT * FROM faculty WHERE first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ? OR position LIKE ? ORDER BY id DESC');
            $stmt->execute([$like, $like, $like, $like]);
        } else {
            $stmt = $this->db->query('SELECT * FROM faculty ORDER BY id DESC');
        }
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM faculty WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $d): bool
    {
        $stmt = $this->db->prepare('INSERT INTO faculty (first_name, middle_name, last_name, age, gender, address, position, salary) VALUES (?,?,?,?,?,?,?,?)');
        return $stmt->execute($this->values($d));
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare('UPDATE faculty SET first_name=?, middle_name=?, last_name=?, age=?, gender=?, address=?, position=?, salary=? WHERE id=?');
        return $stmt->execute([...$this->values($d), $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM faculty WHERE id = ?');
        return $stmt->execute([$id]);
    }

    private function values(array $d): array
    {
        return [$d['first_name'], $d['middle_name'] !== '' ? $d['middle_name'] : null, $d['last_name'],
                (int)$d['age'], $d['gender'], $d['address'], $d['position'], $d['salary']];
    }
}
