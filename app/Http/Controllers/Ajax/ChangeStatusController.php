<?php
namespace App\Http\Controllers\Ajax;

use App\Models\Database;
use App\Http\Repositories\BaseRepository;
use App\Traits\HasHook;
use App\Traits\HasCache;
use App\Http\Services\Impl\Realtime\PusherService;
use App\Enums\PusherChanel;
use App\Enums\PusherEvent;
use App\Http\Repositories\Product\UnitProductRepository;
use App\Http\Repositories\Checkout\OrderRepository;
class ChangeStatusController
{
    use HasHook, HasCache;
    private BaseRepository $baseRepository;
    private UnitProductRepository $unitProductRepository;
    private OrderRepository $orderRepository;
    private PusherService $pusherService;
    private $result;
    public function __construct(
        PusherService $pusherService,
        UnitProductRepository $unitProductRepository,
        OrderRepository $orderRepository,
    )
    {
        $model = Database::connection();
        $this->pusherService = $pusherService;
        $this->baseRepository = new BaseRepository($model);
        $this->unitProductRepository = new UnitProductRepository($model);
        $this->orderRepository = new OrderRepository($model);
    }

    /**
     * @throws \Exception
     */
    public function changeStatusSingle(): void
    {
        header('Content-Type: application/json');
        try {
            $payload = $_POST;
            $payload['value'] = ($_POST['value'] == 1) ? 2 : 1;
            $this->cacheKeyPrefix = $payload['field'];
            if($payload['field'] === 'admins'){
                $this->beginTransaction()->change($payload)->callForceLogout($payload['id'])->commit();
            };
            $this->beginTransaction()->change($payload)->commit();
            echo json_encode(['status' => true, 'new_publish' => $payload['value']]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }

    private function callForceLogout (int $id = null): self
    {
        $this->pusherService->push(PusherChanel::LOGOUT_FORCE,PusherEvent::NEW_LOGOUT_FORCE, ['admin_id' => $id, 'message' => "Bạn đã bị thu hồi quyền truy cập"]);
        return $this;
    }

    public function getAllUnitProduct(): void
    {
        header('Content-Type: application/json');
        try {
            $unitIds = $this->unitProductRepository->all();
            echo json_encode(['status' => true, 'unitIds' => $unitIds['data']]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function changeSingleOrderTop(): void
    {
        header('Content-Type: application/json');
        try {
            $payload = $_POST;
            $payload['value'] = $_POST['value'] ?? 0;
            $this->cacheKeyPrefix = $payload['field'];
            if($payload['field'] === 'admins'){
                $this->beginTransaction()->change($payload)->callForceLogout($payload['id'])->commit();
            };
            $this->beginTransaction()->change($payload)->commit();
            echo json_encode(['status' => true, 'newOrder' => $payload['value']]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function bulkChangeStatusOrder(): void
    {
        header('Content-Type: application/json');
        try {
            $data = $_POST['data'];
            foreach ($data as &$val) {
                if ($val['status'] === 4) continue;

                if ($val['status'] < 3) $val['status'] += 1;

                $this->orderRepository->changeStatusOrder($val);
            }
            echo json_encode(['status' => true, 'message' => 'success']);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function cancelOrder(): void
    {
        header('Content-Type: application/json');
        try {
            $data = [
                'status' => 4,
                'id' => $_POST['orderId']
            ];
            $this->orderRepository->changeStatusOrder($data);
            echo json_encode(['status' => true, 'message' => 'success']);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }
}