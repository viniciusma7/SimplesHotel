<?php

namespace App\Repositories;

use App\Models\Tarefa;
use Illuminate\Contracts\Pagination\Paginator;

class EloquentTarefaRepository implements TarefaRepositoryInterface
{
    public function paginateByUser(int $userId, ?string $status = null, int $perPage = 15): Paginator
    {
        $query = Tarefa::query()->where('user_id', $userId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('id', 'asc')->paginate($perPage);
    }

    public function paginateTrashedByUser(int $userId, int $perPage = 15): Paginator
    {
        return Tarefa::onlyTrashed()->where('user_id', $userId)->orderBy('id', 'asc')->paginate($perPage);
    }

    public function createForUser(array $data, int $userId): Tarefa
    {
        return Tarefa::create(array_merge($data, ['user_id' => $userId]));
    }

    public function update(Tarefa $tarefa, array $data): bool
    {
        return $tarefa->update($data);
    }

    public function delete(Tarefa $tarefa): bool
    {
        return (bool) $tarefa->delete();
    }

    public function restoreByIdForUser(int $id, int $userId): ?Tarefa
    {
        $tarefa = Tarefa::withTrashed()->where('id', $id)->where('user_id', $userId)->first();

        if ($tarefa && $tarefa->trashed()) {
            $tarefa->restore();
            return $tarefa;
        }

        return null;
    }

    public function toggleStatus(Tarefa $tarefa): Tarefa
    {
        $tarefa->status = $tarefa->status === 'pendente' ? 'concluida' : 'pendente';
        $tarefa->save();

        return $tarefa;
    }
}
