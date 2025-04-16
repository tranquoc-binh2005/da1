<?php
namespace App\Enums;

enum Response: int
{
    // 2xx - Thành công
    public const OK = 200;
    public const CREATED = 201;
    public const NO_CONTENT = 204;

    // 3xx - Chuyển hướng
    public const MOVED_PERMANENTLY = 301;
    public const FOUND = 302;
    public const NOT_MODIFIED = 304;

    // 4xx - Lỗi phía Client
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const REQUEST_TIMEOUT = 408;
    public const TOO_MANY_REQUESTS = 429;

    // 5xx - Lỗi phía Server
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;
    public const BAD_GATEWAY = 502;
    public const SERVICE_UNAVAILABLE = 503;
    public const GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    public static function message(int $code): string
    {
        return match ($code) {
            // 2xx - Thành công
            self::OK => 'Thành công',
            self::CREATED => 'Đã tạo',
            self::NO_CONTENT => 'Không có nội dung',

            // 3xx - Chuyển hướng
            self::MOVED_PERMANENTLY => 'Chuyển hướng vĩnh viễn',
            self::FOUND => 'Đã tìm thấy',
            self::NOT_MODIFIED => 'Không thay đổi',

            // 4xx - Lỗi phía Client
            self::BAD_REQUEST => 'Yêu cầu không hợp lệ',
            self::UNAUTHORIZED => 'Không được ủy quyền',
            self::FORBIDDEN => 'Bị cấm truy cập',
            self::NOT_FOUND => 'Không tìm thấy',
            self::METHOD_NOT_ALLOWED => 'Phương thức không được phép',
            self::REQUEST_TIMEOUT => 'Hết thời gian yêu cầu',
            self::TOO_MANY_REQUESTS => 'Quá nhiều yêu cầu',

            // 5xx - Lỗi phía Server
            self::INTERNAL_SERVER_ERROR => 'Lỗi máy chủ nội bộ',
            self::NOT_IMPLEMENTED => 'Chưa được triển khai',
            self::BAD_GATEWAY => 'Cổng không hợp lệ',
            self::SERVICE_UNAVAILABLE => 'Dịch vụ không khả dụng',
            self::GATEWAY_TIMEOUT => 'Hết thời gian phản hồi từ cổng',
            self::HTTP_VERSION_NOT_SUPPORTED => 'Phiên bản HTTP không được hỗ trợ',

            default => 'Mã trạng thái không xác định',
        };
    }
}
