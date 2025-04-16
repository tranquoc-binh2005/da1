<?php
namespace App\Traits;

use Exception;
use App\Traits\Str;
trait HasRequest
{
    use Str;
    protected array $errors = [];
    protected array $validatedData = [];

    /**
     * Xác thực dữ liệu đầu vào.
     *
     * @return bool
     * @throws Exception
     */
    protected function validate(): void
    {
        $this->errors = [];
        $data = $this->all();
        $rules = $this->rules();
        $validated = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArray = array_filter(explode('|', trim($ruleString)));
            foreach ($rulesArray as $rule) {
                if (!$this->checkRule($data[$field] ?? null, $rule)) {
                    $this->errors[$field][] = $this->messages($field, $rule);
                }
            }

            if (!isset($this->errors[$field]) && isset($data[$field])) {
                $validated[$field] = $data[$field];
            }
        }

        $this->validatedData = $validated;
    }

    /**
     * Kiểm tra quy tắc cho một trường cụ thể.
     *
     * @param mixed $value
     * @param string $rule
     * @return bool
     */
    private function checkRule($value, string $rule): bool
    {
        $paramList = explode(':', $rule);
        $ruleName = $paramList[0];

        switch ($ruleName) {
            case 'required':
                return !empty($value);
            case 'string':
                return is_string($value);
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'min':
                return strlen($value ?? '') >= (int) ($paramList[1] ?? 0);
            case 'same':
                $payload = $this->all();
                $compareField = $paramList[1] ?? '';
                return isset($payload[$compareField]) && $payload[$compareField] === $value;
            case 'array':
                return is_array($value);
            case 'exists':
                if($rule === 'exists:products:canonical'){
                    $value = $this->convertStringToSlug($value);
                }
                return $this->checkExists($value, $paramList[1] ?? '', $paramList[2] ?? '', $paramList[3] ?? null);
            default:
                return true;
        }
    }

    private function checkExists($value, string $table, string $column, ?string $id = null): bool
    {
        $query = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :value";
        $params = ['value' => $value];

        if ($id) {
            $query .= " AND id != :id";
            $params['id'] = $id;
        }

        $result = $this->baseRepository->find($query, $params);

        return $result['count'] == 0;
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