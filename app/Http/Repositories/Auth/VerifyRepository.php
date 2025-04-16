<?php
namespace App\Http\Repositories\Auth;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\VerifyRepositoryInterface;
use App\Models\VerifyEmail;
use App\Models\Database;
use PDO;

class VerifyRepository extends BaseRepository implements VerifyRepositoryInterface
{
    protected PDO $database;
    protected VerifyEmail $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new VerifyEmail();
        parent::__construct($this->model);
    }

    public function createVerify(array $data = [])
    {
        try {
            $sqlDelete = "DELETE FROM verify_email WHERE email = :email";
            $this->execute($sqlDelete, [':email' => $data['email']]);
            $sql = "INSERT INTO verify_email (email, code, expire_at, dead_at, was_use) VALUES (:email, :code, :expire_at, :dead_at, :was_use)";
            $params = [
                ':email' => $data['email'],
                ':code' => $data['code'],
                ':expire_at' => $data['expire_at'],
                ':dead_at' => date('Y-m-d H:i:s', strtotime('+30 day')),
                ':was_use' => null,
            ];
            return $this->insert($sql, $params);
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function verify(int $code)
    {
        try {
            $sql = "SELECT * FROM verify_email 
                    WHERE code = :code AND dead_at > NOW() AND was_use IS NULL
                    LIMIT 1";
            return $this->execute($sql, [':code' => $code]);
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function revoke(int $code)
    {
        try {
            $sql = "UPDATE verify_email 
                    SET was_use = 1 
                    WHERE code = :code AND dead_at > NOW()";
            if(!$this->execute($sql, [':code' => $code])){
                return false;
            }
            return true;
        } catch (\Exception $e){
            throw $e;
        }
    }
}