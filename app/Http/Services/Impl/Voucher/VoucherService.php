<?php
namespace App\Http\Services\Impl\Voucher;

use App\Http\Repositories\Interfaces\VoucherRepositoryInterface as VoucherRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Voucher\VoucherServiceInterface;
use App\Models\Voucher;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;
use App\Models\ProductVariant;
use App\Http\Repositories\BaseRepository;

class VoucherService extends BaseService implements VoucherServiceInterface
{
    use HasHook, Str;
    protected VoucherRepository $voucherRepository;
    protected $baseRepository;
    protected Voucher $voucherModel;
    protected ProductVariant $productVariantModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix;
    protected array $fieldSearch = ['tb1.name', 'tb1.description'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['admins'];

    protected const CACHE_KEY_PREFIX = 'vouchers';

    public function __construct(
        VoucherRepository $voucherRepository,
    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->voucherModel = new Voucher();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($voucherRepository, $this->voucherModel);
    }

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['id', 'desc'],
            'keyword' => [
                'q' => $request['keyword'] ?? '',
                'field' => $this->fieldSearch
            ],
            'filters' => [
                'simple' => $this->buildFilter($request, $this->simpleFilter),
                'complex' => $this->buildFilter($request, $this->complexFilter),
                'date' => $this->buildFilter($request, $this->dateFilter),
            ],
            'with' => $this->with
        ];
    }

    public function prepareModelData(array $payload = []): self
    {
        $this->initializeBasicData($payload);
        return $this;
    }

    private function initializeBasicData(array $payload = []): void
    {
        $payload['admin_id'] = $_SESSION['admin']['id'] ?? "";
        $this->payload = $payload;
    }
}