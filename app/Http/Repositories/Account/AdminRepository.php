<?php
namespace App\Http\Repositories\Account;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use App\Models\Database;
use PDO;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    protected PDO $database;
    public function __construct()
    {
        $this->database = Database::connection();
        $model = new Admin();
        parent::__construct($model);
    }
}