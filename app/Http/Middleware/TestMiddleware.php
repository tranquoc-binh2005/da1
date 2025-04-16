<?php
namespace App\Http\Middleware;

use App\Traits\HasRender;

class TestMiddleware
{
    use HasRender;
    public function handle(): void
    {
        echo 124; die();
    }
}
