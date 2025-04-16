<?php
namespace App\Http\Request\Permission;

use App\Http\Repositories\Account\UserRepository;
use App\Http\Request\FormRequest;
use App\Traits\HasRequest;
use Exception;

class SaveRequest extends FormRequest
{
    use HasRequest;
    protected array $validatedData = [];
    protected UserRepository $userRepository;
    /**
     * @var array|mixed
     */
    /**
     * Khi khởi tạo, tự động validate
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->validate();
    }

    public static function capture(): static
    {
        return new static();
    }
    /**
     * Định nghĩa các quy tắc xác thực.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'permission' => 'required',
            'role_id' => 'required',
        ];
    }

    public function messages(string $field, string $rule): string
    {
        $customMessages = [
            'required' => "Cần ít nhất có 1 quyền",
        ];

        return $customMessages[$rule] ?? "Trường {$field} không hợp lệ.";
    }

    /**
     * Lấy dữ liệu đã được validate
     *
     * @return array
     */
    public function validated(): array
    {
        return $this->validatedData;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
