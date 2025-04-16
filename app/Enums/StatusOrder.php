<?php
namespace App\Enums;

enum StatusOrder: int
{
    public const WAITING = 1;
    public const PROCESSING = 2;
    public const SUCCESS = 3;
    public const FAILED = 4;
}
