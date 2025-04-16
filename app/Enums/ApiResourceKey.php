<?php
namespace App\Enums;

enum ApiResourceKey: string
{
    public const STATUS = 'status';
    public const CODE = 'code';
    public const MESSAGE = 'message';
    public const DATA = 'data';
    public const TIMESTAMP = 'timestamp';
    public const ERROR = 'error';
}