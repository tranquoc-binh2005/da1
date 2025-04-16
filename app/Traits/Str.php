<?php
namespace App\Traits;

trait Str
{
    protected function convertStringToSlug(string $string = ""): string
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = preg_replace('/[^a-z0-9\s\-\àáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳýỷỹỵđ]/u', '', $string);
        $string = str_replace(['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'], 'a', $string);
        $string = str_replace(['è', 'é', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'], 'e', $string);
        $string = str_replace(['ì', 'í', 'ỉ', 'ĩ', 'ị'], 'i', $string);
        $string = str_replace(['ò', 'ó', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'], 'o', $string);
        $string = str_replace(['ù', 'ú', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'], 'u', $string);
        $string = str_replace(['ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ'], 'y', $string);
        $string = str_replace('đ', 'd', $string);

        $string = preg_replace('/\s+/', '-', trim($string));

        return trim($string, '-');
    }

    protected function formatCurrency(mixed $number): string
    {
        $number = preg_replace('/[^0-9]/', '', (string)$number);

        if ($number === '' || !is_numeric($number)) {
            return '0đ';
        }

        return number_format((int)$number, 0, ',', '.') . 'đ';
    }

}