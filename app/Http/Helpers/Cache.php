<?php
namespace App\Http\Helpers;

use Predis\Client;
use App\Enums\env;
class Cache
{
    protected static Client $client;
    protected const PREFIX = 'da1_';

    protected static function init(): void
    {
        if (!isset(self::$client)) {
            $config = [
                'scheme'   => 'tcp',
                'host'     => env::PREDIS_HOST,
                'port'     => env::PREDIS_PORT,
                'password' => env::PREDIS_PASSWORD,
                'database' => env::PREDIS_DATABASE,
            ];

            $options = [
                'prefix' => self::PREFIX
            ];

            self::$client = new Client($config, $options);
        }
    }

    public static function set(string $key, mixed $value, int $ttl = null): ?\Predis\Response\Status
    {
        self::init();
        $value = json_encode($value);
        return $ttl
            ? self::$client->setex($key, $ttl, $value)
            : self::$client->set($key, $value);
    }

    public static function get(string $key): mixed
    {
        self::init();
        $data = self::$client->get(self::PREFIX . $key);
        return $data ? json_decode($data) : null;
    }

    public static function del(string $key): int
    {
        self::init();
        return self::$client->del([$key]);
    }

    public static function exists(string $key): int
    {
        self::init();
        return self::$client->exists($key);
    }

    public static function setGroup(string $key, array $data, int $ttl = null): ?\Predis\Response\Status
    {
        $json = json_encode($data);
        return self::set($key, $json, $ttl);
    }

    public static function getGroup(string $key): ?array
    {
        $data = self::get($key);
        return $data ? json_decode($data, true) : null;
    }

    public static function flushAll()
    {
        self::init();
        return self::$client->flushall();
    }

    public static function flush(array $patterns): array
    {
        self::init();
        self::$client->select(env::PREDIS_DATABASE);

        $deletedKeys = [];

        foreach ($patterns as $pattern) {
            $iterator = null;
            $patternWithWildcard = $pattern . '*'; // thêm * vào cuối nếu chưa có

            do {
                $result = self::$client->scan($iterator, [
                    'match' => $patternWithWildcard,
                    'count' => 100,
                ]);

                $iterator = $result[0];

                if (!empty($result[1])) {
                    foreach ($result[1] as $key) {
                        self::$client->del($key);
                        $deletedKeys[] = $key;
                    }
                }
            } while ($iterator != 0);
        }
        return $deletedKeys;
    }
}
