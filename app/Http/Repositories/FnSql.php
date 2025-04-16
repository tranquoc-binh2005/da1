<?php
namespace App\Http\Repositories;

use App\Models\Database;
use Exception;
use PDOException;
use PDO;

class FnSql
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    /**
     *
     * @param string $sql
     * @param array $params
     * @return array
     * @throws PDOException
     */
    public function get(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @throws Exception
     */
    public function find(string $sql, array $params = []): ?array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            throw new Exception("Lỗi tìm dữ liệu: " . $e->getMessage());
        }
    }

    /**
     * Chèn dữ liệu vào bảng
     *
     * @param string $sql
     * @param array $params
     * @return int ID của bản ghi mới
     * @throws PDOException
     */
    public function insert(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $this->pdo->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Lỗi chèn dữ liệu: " . $e->getMessage());
        }
    }

    /**
     * Thực thi câu lệnh SQL (UPDATE, DELETE)
     *
     * @param string $sql
     * @param array $params
     * @return int Số dòng bị ảnh hưởng
     * @throws PDOException
     */
    public function execute(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi thực thi: " . $e->getMessage());
        }
    }

    public function paginate(int $perPage = 20): array
    {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $perPage;

        // Đếm tổng dòng an toàn hơn (subquery)
        $countQuery = "SELECT COUNT(*) as total FROM ({$this->query}) AS sub";
        $stmt = $this->pdo->query($countQuery);
        $totalItems = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Lấy dữ liệu
        $paginatedQuery = $this->query . " LIMIT {$perPage} OFFSET {$offset}";
        $stmt = $this->pdo->query($paginatedQuery);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Phân trang
        $totalPages = ceil($totalItems / $perPage);
        $nextPage = $currentPage < $totalPages ? $currentPage + 1 : null;
        $prevPage = $currentPage > 1 ? $currentPage - 1 : null;

        return [
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total_items' => (int)$totalItems,
            'total_pages' => $totalPages,
            'next_page' => $nextPage,
            'prev_page' => $prevPage,
            'data' => $data,
        ];
    }

    public function upsert(string $table, array $data, array $updateFields): int
    {
        try {
            $columns = array_keys($data);
            $placeholders = array_fill(0, count($columns), '?');
            $updateSet = implode(', ', array_map(fn($field) => "$field = VALUES($field)", $updateFields));
            $sql = "INSERT INTO $table (" . implode(',', $columns) . ") 
                VALUES (" . implode(',', $placeholders) . ") 
                ON DUPLICATE KEY UPDATE $updateSet";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($data));

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi Upsert: " . $e->getMessage());
        }
    }

    public function getBeginTransaction(): self {
        $this->pdo->beginTransaction();
        return $this;
    }

    public function getCommit(): self {
        $this->pdo->commit();
        return $this;
    }

    public function getRollback(): self {
        $this->pdo->rollBack();
        return $this;
    }
}
