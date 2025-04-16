<?php
namespace App\Traits;

use App\Http\Resources\ApiResource;
use App\Enums\Response;
trait Loggable
{
    protected function handleLogException(\Exception $e): void
    {
        $logFile = 'app/Log/error.log';

        $content = [
            "Message" => $e->getMessage(),
            "File" => $e->getFile(),
            "Line" => $e->getLine(),
            "Time" => date("Y-m-d H:i:s"),
        ];

        if(file_exists($logFile)) {
            $logMessage = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
            file_put_contents($logFile, $logMessage, FILE_APPEND);
        }

        ApiResource::messsage("Đã có lỗi xảy ra", Response::INTERNAL_SERVER_ERROR);
    }

    public function logTimeQuery(array $event = []): void
    {
        $logFile = 'app/Log/timequery.log';

        $content = [
            "Modules" => $event['module'],
            "File" => $event['file'],
            "Line" => $event['line'],
            "TimeQuery" => $event['time_sec'],
            "Time" => date("Y-m-d H:i:s"),
        ];

        if(file_exists($logFile)) {
            $logMessage = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
            file_put_contents($logFile, $logMessage, FILE_APPEND);
        }
    }
}
