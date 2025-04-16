<?php
namespace App\Http\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\FnSql;
use App\Traits\HasQuery;
use App\Http\Repositories\Interfaces\BaseRepositoryInterface;
class BaseRepository extends FnSql implements BaseRepositoryInterface
{
    use HasQuery;

    private mixed $model;

    public function __construct($model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function __call(string $name, array $arguments): array
    {
        try {
            $field = strtolower(str_replace('findBy', '', $name));
            $sql = "SELECT " . implode(', ', $this->model->getDetail()) . " FROM {$this->model->getTable()} AS tb1 WHERE tb1.{$field} = :value";
            if (!$result = $this->find($sql, ['value' => $arguments[0]])) {
                throw new ModelNotFoundException("Không tìm thấy bản ghi theo {$field}");
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function pagination($specifications): array
    {
        $sql = "SELECT " . implode(', ', array_merge($this->model->getDetail(), $this->model->getFieldJoin())) . " FROM {$this->model->getTable()}";
        $query = $this->setQuery($sql)
            ->relation($specifications['with'])
            ->keyword($specifications['keyword'])
            ->simple($specifications['filters']['simple'])
            ->complex($specifications['filters']['complex'])
            ->date($specifications['filters']['date'])
            ->sort($specifications['sort'])
            ->getQuery();

        if (isset($specifications['type']) && $specifications['type'] === 'all') {
            return ['data' => $this->get($query)];
        }
        return $this->paginate($specifications['perpage']);
    }

    public function all(): array
    {
        $sql = "SELECT " . implode(', ', $this->model->getField()) . " FROM {$this->model->getTable()} as tb1 WHERE tb1.publish = 1";
        $query = $this->setQuery($sql)->getQuery();
        return ['data' => $this->get($query)];
    }


    /**
     * @throws \Exception
     */
    public function create(array $payload = []): int
    {
        try {
            $sql = "INSERT INTO {$this->model->getTable()} ({$payload['fields']}) VALUES ({$payload['placeholders']})";
            return $this->insert($sql, $payload['filteredPayload']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(array $payload = [], int $id = null): int
    {
        try {
            $setClause = [];
            foreach ($payload['filteredPayload'] as $field => $value) {
                $setClause[] = "{$field} = :{$field}";
            }
            $setString = implode(', ', $setClause);

            $sql = "UPDATE {$this->model->getTable()} SET {$setString} WHERE id = :id";
            $payload['filteredPayload']['id'] = $id;
            return $this->execute($sql, $payload['filteredPayload']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete(array $data = [])
    {
        try {
            $sql = "DELETE FROM {$this->model->getTable()} WHERE id = :id";
            return $this->execute($sql, ['id' => $data['id']]);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT " . implode(', ', $this->model->getDetail()) . " FROM {$this->model->getTable()} AS tb1 WHERE tb1.email = :value AND tb1.publish = 1";
        if(!$result = $this->find($sql, ['value' => $email])){
            throw new ModelNotFoundException("Không tìm thấy bản ghi theo {$email}");
        }
        return $result;
    }

    public function changeStatus(array $payload = []): int
    {
        $sql = "UPDATE {$payload['field']} SET {$payload['column']} = {$payload['value']} WHERE id = :id";
        return $this->execute($sql, [':id' => $payload['id']]);
    }

}