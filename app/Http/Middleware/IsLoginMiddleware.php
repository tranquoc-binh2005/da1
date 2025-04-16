<?php
namespace App\Http\Middleware;

use App\Traits\HasRender;
use App\Traits\HasAlert;
class IsLoginMiddleware
{
    use HasRender, HasAlert;
    public function handle(): void
    {
        if (isset($_SESSION['admin'])) {
            header('location: ../dashboard');
        }
    }
}
