<?php
namespace App\Http\Services\Impl\Realtime;

use GuzzleHttp\Exception\GuzzleException;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use App\Enums\env;
use Pusher\PusherException;

class PusherService
{
    protected Pusher $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            env::PUSHER_KEY,
            env::PUSHER_SECRET,
            env::PUSHER_APP_ID,
            [
                'cluster' => env::PUSHER_CLUSTER,
                'useTLS' => env::USE_TLS
            ],
        );
    }

    /**
     * Đẩy dữ liệu realtime
     */
    public function push(string $channel, string $event, array $data): object
    {
        try {
            return $this->pusher->trigger($channel, $event, $data);
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        } catch (ApiErrorException|PusherException $e) {
            echo $e->getMessage();
        }
    }
}
