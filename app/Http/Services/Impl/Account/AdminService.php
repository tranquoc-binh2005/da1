<?php
namespace App\Http\Services\Impl\Account;

use App\Http\Repositories\Interfaces\AdminRepositoryInterface as AdminRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Account\AdminServiceInterface;
use App\Http\Services\Interfaces\Upload\ImageServiceInterface;
use App\Models\Admin;

class AdminService extends BaseService implements AdminServiceInterface
{
    protected AdminRepository $adminRepository;
    protected ImageServiceInterface $imageService;
    protected Admin $adminModel;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish', 'tb1.role_id'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['roles', 'admins'];

    protected const CACHE_KEY_PREFIX = 'admins';
    private const PIPE_LINE_KEY = 'default';

    public function __construct(
        AdminRepository $adminRepository,
        ImageServiceInterface $imageService,
    )
    {
        $this->adminRepository = $adminRepository;
        $this->imageService = $imageService;
        $this->adminModel = new Admin();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($adminRepository, $this->adminModel);
    }

    /**
     * @throws \Exception
     */
    public function prepareModelData(array $payload = []): self
    {
        $this->initializeBasicData($payload)->uploadImage($payload);
        return $this;
    }

    private function initializeBasicData(array $payload = []): self
    {
        $payload['admin_id'] = $_SESSION['admin']['id'];
        if (isset($payload['password']) && !password_get_info($payload['password'])['algo']) {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        }
        $this->payload = $payload;
        return $this;
    }

    private function uploadImage(array $payload = []): void
    {
        try {
            if(!$payload['image']['name'] && empty($payload['image']['name'])){
                unset($this->payload['image']);
                return;
            }
            $uploadConfig = [
                'files' => $payload['image'],
                'pipelineKey' => self::PIPE_LINE_KEY,
                'overrideOptions' => [
                    'optimize' => [
                        'quality' => 20
                    ],
                    'storage' => [
                        'path' => 'public/upload/' . explode('@', $_SESSION['admin']['email'])[0] . '/avatar/' . date('Ymd')
                    ]
                ]
            ];

            $result = $this->imageService->upload(...$uploadConfig);
            $this->payload['image'] = $result['files'][0]['path'];
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}