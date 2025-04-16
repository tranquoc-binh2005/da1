<?php
namespace App\Http\Repositories\Voucher;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\VoucherRepositoryInterface;
use App\Models\Database;
use App\Models\Voucher;
use PDO;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    protected PDO $database;
    protected Voucher $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Voucher();
        parent::__construct($this->model);
    }
}