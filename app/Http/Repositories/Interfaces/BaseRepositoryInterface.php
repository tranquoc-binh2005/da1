<?php
namespace App\Http\Repositories\Interfaces;
interface BaseRepositoryInterface{
    public function __call(string $name, array $arguments): array;
    public function pagination($specifications): array;
    public function all(): array;
    public function create(array $payload = []): int;
    public function update(array $payload = [], int $id = null): int;
    public function delete(array $data = []);
    public function findByEmail(string $email): ?array;
    public function changeStatus(array $payload = []): int;

}