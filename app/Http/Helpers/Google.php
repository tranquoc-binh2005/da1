<?php
namespace App\Http\Helpers;

use Google_Client;

class Google{


    public $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(self::CLIENT_ID);
        $this->client->setClientSecret(self::CLIENT_SECRET);
        $this->client->setRedirectUri('http://localhost:8000/loginGoogle');
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function createAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function getClient(): Google_Client
    {
        return $this->client;
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this->client, $method)) {
            return call_user_func_array([$this->client, $method], $arguments);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}