<?php
namespace App\Http\Repositories\Post;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Database;
use App\Models\Post;
use PDO;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected PDO $database;
    protected Post $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Post();
        parent::__construct($this->model);
    }

    public function findByCanonical(string $canonical): ?array
    {
        try {
            $sql = "SELECT tb1.*, tb2.name as name_catalogues, tb3.name as author 
            FROM posts as tb1
            LEFT JOIN post_catalogues as tb2 ON tb1.post_catalogue_id = tb2.id
            LEFT JOIN admins as tb3 ON tb1.admin_id = tb3.id
            WHERE tb1.canonical = :canonical LIMIT 1";
            return $this->find($sql, [':canonical' => $canonical]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getRelatedPosts(int $post_catalogue_id, int $exclude_id, int $limit = 10): array
    {
        try {
            $sql = "SELECT tb1.*, tb2.name as name_catalogues, tb3.name as author 
                FROM posts as tb1
                LEFT JOIN post_catalogues as tb2 ON tb1.post_catalogue_id = tb2.id
                LEFT JOIN admins as tb3 ON tb1.admin_id = tb3.id
                WHERE tb1.post_catalogue_id = :post_catalogue_id
                AND tb1.id != :exclude_id
                ORDER BY tb1.created_at DESC
                LIMIT " . $limit;

            $params = [
                ':post_catalogue_id' => $post_catalogue_id,
                ':exclude_id' => $exclude_id
            ];
            return $this->get($sql, $params);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}