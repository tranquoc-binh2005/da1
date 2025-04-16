<?php
namespace App\Http\Controllers\Ajax;

class BaseAjaxController
{
    protected function isLogin(): ?array
    {
        if (isset($_SESSION['user'])) return $_SESSION['user'];
        return null;
    }
}