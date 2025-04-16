<?php
namespace App\Http\Repositories\Auth;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\AuthenticateRepositoryInterface;
use App\Models\Authenticate;
use App\Models\Database;
use PDO;

class AuthenticateRepository extends BaseRepository implements AuthenticateRepositoryInterface
{
    protected PDO $database;
    public function __construct()
    {
        $this->database = Database::connection();
        $model = new Authenticate();
        parent::__construct($model);
    }
}