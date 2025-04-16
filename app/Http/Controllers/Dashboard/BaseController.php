<?php
namespace App\Http\Controllers\Dashboard;

use App\Exceptions\ModelNotFoundException;
use App\Traits\HasAlert;
use App\Traits\HasRender;
use App\Traits\Loggable;

class BaseController
{
    use Loggable, HasRender, HasAlert;
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function baseIndex(string $type = ''): array
    {
        try {
            if($type === 'all'){
                return $this->service->all();
            }
            return $this->service->paginate($_GET);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function baseSave(array $payload = [], int $id = null): bool
    {
        try {
            $this->service->save($payload, $id);
            return true;
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function baseShow(int $id = null): array
    {
        try {
            return $this->service->show($id);
        } catch (ModelNotFoundException $e){
            $this->helper('404', ['message' => $e->getMessage(), 'line' => $e->getLine()]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function baseDelete(int $id = null): bool
    {
        try {
            return $this->service->delete($id);
        } catch (ModelNotFoundException $e){
            $this->helper('404', ['message' => $e->getMessage(), 'line' => $e->getLine()]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }
}
