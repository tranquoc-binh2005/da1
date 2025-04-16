<?php
namespace App\Http\Services\Impl\Account;

use App\Http\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Account\UserServiceInterface;
use App\Http\Services\Interfaces\Upload\ImageServiceInterface;
use App\Models\User;

class UserService extends BaseService implements UserServiceInterface
{
    protected UserRepository $userRepository;
    protected ImageServiceInterface $imageService;
    protected User $userModel;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = [];

    protected const CACHE_KEY_PREFIX = 'users';
    private const PIPE_LINE_KEY = 'default';

    public function __construct(
        UserRepository $userRepository,
        ImageServiceInterface $imageService
    )
    {
        $this->userRepository = $userRepository;
        $this->imageService = $imageService;
        $this->userModel = new User();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($userRepository, $this->userModel);
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
        if (isset($payload['password']) && !password_get_info($payload['password'])['algo']) {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        }
        $this->payload = $payload;
        return $this;
    }

    /**
     * @throws \Exception
     */
    private function uploadImage(array $payload = []): self
    {
        try {
            if(empty($payload['image'])) return $this;
            $uploadConfig = [
                'files' => $payload['image'] ?? [],
                'pipelineKey' => self::PIPE_LINE_KEY,
                'overrideOptions' => [
                    'optimize' => [
                        'quality' => 20
                    ],
                    'storage' => [
                        'path' => 'public/upload/' . explode('@', $_SESSION['user']['email'])[0] . '/avatar/' . date('Ymd')
                    ]
                ]
            ];

            $result = $this->imageService->upload(...$uploadConfig);
            $this->payload['image'] = $result['files'][0]['path'];
            return $this;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}