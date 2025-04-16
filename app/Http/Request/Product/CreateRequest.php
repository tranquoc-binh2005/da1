<?php
namespace App\Http\Request\Product;

use App\Http\Request\FormRequest;
use Exception;
use App\Traits\HasRequest;

class CreateRequest extends FormRequest
{
    use HasRequest;
    protected array $validatedData = [];
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
            'name' => 'required|string',
            'canonical' => 'required|string|exists:products:canonical',
            'description' => 'nullable',
            'content' => 'nullable',
            'meta_title' => 'nullable',
            'meta_keyword' => 'nullable',
            'meta_description' => 'nullable',
            'image' => 'nullable',
            'publish' => 'nullable',
            'album' => 'nullable',
            'product_catalogue_id' => 'required',
            'brand_product_id' => 'required',
            'order' => 'nullable',
            'price' => 'required',
            'unit_id' => 'required',
            'sku' => 'required',
            'stock' => 'required',
            'discount' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable'
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
            'exists:products:canonical' => "Đường dẫn đã tồn tại, vui lòng thử lại"
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
