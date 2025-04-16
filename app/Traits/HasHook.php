<?php
namespace App\Traits;

use App\Enums\PusherChanel;
use App\Enums\PusherEvent;
use App\Exceptions\ModelNotFoundException;

trait HasHook
{
    protected function beginTransaction(): self
    {
        $this->baseRepository->getBeginTransaction();
        return $this;
    }

    protected function commit(): self
    {
        $this->baseRepository->getCommit();
        return $this;
    }

    protected function rollback(): self
    {
        $this->baseRepository->getRollback();
        return $this;
    }

    protected function beforeSave(): self {
        $filteredPayload = array_intersect_key($this->payload, array_flip($this->baseModel->fillAble()));
        $fields = implode(', ', array_keys($filteredPayload));
        $placeholders = ':' . implode(', :', array_keys($filteredPayload));
        $this->data = [
            'fields' => $fields,
            'placeholders' => $placeholders,
            'filteredPayload' => $filteredPayload
        ];
        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function saveModel(?int $id = null): self{
        if($id){
            $result = $this->baseRepository->update($this->data, $id);
            $this->result = $id;
        }else{
            $result = $this->baseRepository->create($this->data);
            $this->result = $result;
        }
        return $this;
    }

    protected function afterSave(int $id = null):self {
        return $this->clearSingleRecordCache($id)->cacheSingleRecord()->clearCollectionRecordCache();
    }

    protected function getResult(): mixed {
        return $this->result;
    }

    protected function afterDelete(int $id = null): self{
        return $this->clearSingleRecordCache($id)->clearCollectionRecordCache();
    }

    protected function afterChange(int $id = null): self{
        return $this->clearSingleRecordCache($id)->clearCollectionRecordCache();
    }

    public function change(array $payload = []): self
    {
        $this->result = $this->baseRepository->changeStatus($payload);
        return $this;
    }
    protected function beforeDelete(int $id): self {
        if(! $this->data = $this->baseRepository->findById($id)){
            throw new ModelNotFoundException("Không tìm thấy bản ghi phù hợp");
        }
        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function deleteModel(): self {
        $this->result = $this->baseRepository->delete($this->data);
        return $this;
    }

    protected function callNested($nested): void
    {
        $nested->get();
        $nested->recursive(0, $nested->set());
        $nested->action();
    }
}
