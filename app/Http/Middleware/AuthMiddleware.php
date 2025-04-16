<?php
namespace App\Http\Middleware;

use App\Traits\HasRender;
use App\Traits\HasAlert;
class AuthMiddleware
{
    use HasRender, HasAlert;
    public function handle(): void
    {
        if (!isset($_SESSION['admin'])) {
            $this->view('auth/login')->with('error', 'Vui lòng đăng nhập');
            die();
        }
        if($_SESSION['admin']['publish'] !== 1){
            $this->view('auth/login')->with('error', 'Vui lòng đăng nhập');
            die();
        }
    }
}
