<?php
namespace App\Http\Resources;

use App\Enums\Response;
use App\Enums\ApiResourceKey;

class ApiResource
{
    public const DATE = "Y-m-d H:i:s";
    public static function ok(mixed $data = null, string $message = '', int $code = Response::OK)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            ApiResourceKey::STATUS => true,
            ApiResourceKey::CODE => $code,
            ApiResourceKey::MESSAGE => $message ?: self::defaultMessage($code),
            ApiResourceKey::DATA => $data,
            ApiResourceKey::TIMESTAMP => date(self::DATE),
        ]);
        exit();
    }

    public static function error(mixed $error = null, string $message = '', int $code = Response::INTERNAL_SERVER_ERROR)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            ApiResourceKey::STATUS => false,
            ApiResourceKey::CODE => $code,
            ApiResourceKey::MESSAGE => $message ?: self::defaultMessage($code),
            ApiResourceKey::ERROR => $error,
            ApiResourceKey::TIMESTAMP => date(self::DATE),
        ]);
        exit();
    }

    public static function messsage(string $message = '', int $code = Response::OK)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            ApiResourceKey::STATUS => $code === Response::OK,
            ApiResourceKey::MESSAGE => $message ?: self::defaultMessage($code),
            ApiResourceKey::TIMESTAMP => date(self::DATE),
        ]);
        exit();
    }

    private static function defaultMessage(int $status): string
    {
        return match ($status) {
            200 => 'Thành công',
            201 => 'Đã tạo',
            204 => 'Không có nội dung',
            400 => 'Yêu cầu không hợp lệ',
            401 => 'Không được ủy quyền',
            403 => 'Bị cấm',
            404 => 'Không tìm thấy',
            405 => 'Phương thức không được phép',
            500 => 'Lỗi máy chủ nội bộ',
            default => 'Lỗi không xác định',
        };
    }
}