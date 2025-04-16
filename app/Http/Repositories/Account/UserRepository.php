<?php
namespace App\Http\Repositories\Account;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Database;
use App\Models\User;
use PDO;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected PDO $database;
    public function __construct()
    {
        $this->database = Database::connection();
        $model = new User();
        parent::__construct($model);
    }

    public function createAccount(array $data)
    {
        try {
            $currentDate = date('Y-m-d');
            $sql = "INSERT INTO users (email, password, created_at, updated_at) 
                VALUES(:email, :password, :created_at, :updated_at)";

            return $this->insert($sql, [
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':created_at' => $currentDate,
                ':updated_at' => $currentDate
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function checkIsPassword(array $payload): bool
    {
        try {
            $sql = "SELECT password FROM users WHERE email = :email LIMIT 1";
            $result = $this->find($sql, [':email' => $payload['email']]);

            if (!empty($result)) {
                $hashedPassword = $result['password'];

                if (password_verify($payload['password'], $hashedPassword)) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changePassword(array $payload): bool
    {
        try {
            $hashedPassword = password_hash($payload['new_password'], PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password = :password WHERE email = :email";
            return $this->execute($sql, [
                ':password' => $hashedPassword,
                ':email' => $payload['email']
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}