<?php
namespace App\Enums;

enum env: string
{
    public const URL_NGROK = 'https://c08c-125-235-238-145.ngrok-free.app';
    public const URL = 'http://localhost:8000';
    public const DB_HOST = 'localhost';
    public const USER_NAME = 'root';
    public const PASSWORD = 'root';
    public const DB = 'da1';

    public const PREDIS_HOST = '127.0.0.1';
    public const PREDIS_PORT = 6379;
    public const PREDIS_PASSWORD = '';
    public const PREDIS_DATABASE = 0;

    public const PUSHER_APP_ID = 1963182;
    public const PUSHER_KEY = '4a687436f925f3d980e1';
    public const PUSHER_SECRET = 'f22a484554d7752d145e';
    public const PUSHER_CLUSTER = 'ap1';
    public const USE_TLS = true;
}