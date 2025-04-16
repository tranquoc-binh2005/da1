<?php
namespace App\Http\Repositories\AddressShopping;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\AddressShoppingRepositoryInterface;
use App\Models\Database;
use App\Models\AddressShopping;
use PDO;

class AddressShoppingRepository extends BaseRepository implements AddressShoppingRepositoryInterface
{
    protected PDO $database;
    protected AddressShopping $model;

    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new AddressShopping();
        parent::__construct($this->model);
    }

    public function createAddressShopping(array $data): int
    {
        try {
            $this->database->beginTransaction();

            if ((int)$data['isDefault'] === 1) {
                $this->resetDefaultAddress($data['user_id']);
            }

            $fields = implode(', ', $this->model->fillAble());
            $placeholders = ':' . implode(', :', $this->model->fillAble());
            $sql = "INSERT INTO {$this->model->getTable()} ($fields) VALUES ($placeholders)";
            $params = [
                ':user_id'   => $data['user_id'],
                ':name'      => $data['name'],
                ':address'   => $data['address'],
                ':phone'     => $data['phone'],
                ':isDefault' => $data['isDefault'],
            ];

            $id = $this->insert($sql, $params);

            $this->database->commit();
            return $id;
        } catch (\Exception $e) {
            $this->database->rollBack();
            throw $e;
        }
    }

    public function getAllAddressShopping(int $userId): array
    {
        try {
            $fields = implode(', ', $this->model->getField());
            $sql = "SELECT {$fields} FROM {$this->model->getTable()} as tb1 WHERE tb1.user_id=:user_id ORDER BY tb1.isDefault ASC, tb1.id DESC";
            return $this->get($sql, [':user_id' => $userId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function detailAddressShopping(array $payload): array
    {
        try {
            $fields = implode(', ', $this->model->getField());
            $sql = "SELECT {$fields} FROM {$this->model->getTable()} as tb1 WHERE tb1.user_id=:user_id AND tb1.id = :id LIMIT 1";
            return $this->find($sql, [':user_id' => $payload['user_id'], ':id' => $payload['id']]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteAddressShopping(int $id): int
    {
        try {
            $sql = "DELETE FROM {$this->model->getTable()} WHERE id=:id";
            return $this->execute($sql, [':id' => $id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateAddressShopping(array $data): bool
    {
        try {
            $this->database->beginTransaction();

            if ((int)$data['isDefault'] === 1) {
                $this->resetDefaultAddress($data['user_id']);
            }

            $sql = "UPDATE {$this->model->getTable()} SET 
                    name = :name,
                    address = :address,
                    phone = :phone,
                    isDefault = :isDefault
                    WHERE id = :id AND user_id = :user_id";

            $params = [
                ':name'      => $data['name'],
                ':address'   => $data['address'],
                ':phone'     => $data['phone'],
                ':isDefault' => $data['isDefault'],
                ':id'        => $data['addressId'],
                ':user_id'   => $data['user_id']
            ];

            $result = $this->execute($sql, $params);

            $this->database->commit();
            return $result > 0;
        } catch (\Exception $e) {
            $this->database->rollBack();
            throw $e;
        }
    }

    private function resetDefaultAddress(int $userId): void
    {
        $sql = "UPDATE {$this->model->getTable()} SET isDefault = 2 WHERE user_id = :user_id";
        $this->execute($sql, [':user_id' => $userId]);
    }

    public function getAddressDefault(int $userId): array
    {
        try {
            $fields = implode(', ', $this->model->getField());
            $sql = "SELECT {$fields} FROM {$this->model->getTable()} as tb1 WHERE tb1.user_id=:user_id AND tb1.isDefault = 1 LIMIT 1";
            return $this->find($sql, [':user_id' => $userId]) ?? [];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}