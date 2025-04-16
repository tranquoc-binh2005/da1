<?php
namespace App\Http\Middleware;

use App\Traits\HasRender;
use App\Traits\HasAlert;
class ClientIsLogin
{
    use HasRender, HasAlert;
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('location: ../dang-nhap');
        }
    }
}
