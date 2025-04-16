<?php
namespace App\Http\Request\ProductCatalogue;

use App\Http\Repositories\Account\UserRepository;
use App\Http\Request\FormRequest;
use App\Traits\HasRequest;
use Exception;

class UpdateRequest extends FormRequest
{
    use HasRequest;
    protected array $validatedData = [];
    protected ?int $id = null;
    protected UserRepository $userRepository;
    /**
     * @var array|mixed
     */
    /**
     * Khi khởi tạo, tự động validate
     * @throws Exception
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
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
            'name' => 'required|string',
            'admin_id' => 'nullable',
            'canonical' => "required|exists:product_catalogues:canonical:{$this->id}",
            'description' => 'nullable',
            'meta_title' => 'nullable',
            'meta_keyword' => 'nullable',
            'meta_description' => 'nullable',
            'image' => 'nullable',
            'publish' => 'nullable',
            'parent_id' => 'nullable',
            'lft' => 'nullable',
            'rgt' => 'nullable',
            'order' => 'nullable',
        ];
    }

    public function messages(string $field, string $rule): string
    {
        $customMessages = [
            'required' => "Trường {$field} không được để trống.",
            'string' => "Trường {$field} phải là chuỗi.",
            'email' => "Trường {$field} phải là địa chỉ email hợp lệ.",
            'min:6' => "Mật khẩu phải từ 6 kí tự",
            'same:password' => "Mật khẩu phải giống nhau",
            "exists:product_catalogues:canonical:{$this->id}" => "Đường dẫn này đã tồn tại, vui lòng thử đường dẫn khác"
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
