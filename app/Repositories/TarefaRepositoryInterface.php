<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use App\Models\Tarefa;

interface TarefaRepositoryInterface
{
    public function paginateByUser(int $userId, ?string $status = null, int $perPage = 15): Paginator;

    public function paginateTrashedByUser(int $userId, int $perPage = 15): Paginator;

    public function createForUser(array $data, int $userId): Tarefa;

    public function update(Tarefa $tarefa, array $data): bool;

    public function delete(Tarefa $tarefa): bool;

    public function restoreByIdForUser(int $id, int $userId): ?Tarefa;

    public function toggleStatus(Tarefa $tarefa): Tarefa;
}
