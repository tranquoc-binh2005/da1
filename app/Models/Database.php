<?php
namespace App\Models;

use PDO;
use PDOException;
use App\Enums\env;

class Database
{
    public static function connection(): PDO
    {
        try {
            return new PDO(
                "mysql:host=" . env::DB_HOST . ";dbname=" . env::DB . ";charset=utf8mb4",
                env::USER_NAME,
                env::PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => false // Không dùng kết nối persistent
                ]
            );
        } catch (PDOException $e) {
            die("Lỗi kết nối DB: " . $e->getMessage());
        }
    }

    public static function testConnection(): void
    {
        try {
            $db = self::connection();
            if ($db instanceof PDO) {
                echo "✅ Kết nối thành công đến database!";
            } else {
                echo "❌ Kết nối thất bại!";
            }
        } catch (PDOException $e) {
            echo "❌ Lỗi kết nối: " . $e->getMessage();
        }
    }
}
