<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarefaRequest;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TarefaRepositoryInterface;

class TarefasController extends Controller
{
    private TarefaRepositoryInterface $repository;

    public function __construct(TarefaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $excluidos = $request->query('excluidos');

        if ($excluidos) {
            $tarefas = $this->repository->paginateTrashedByUser(auth()->id(), 15)->withQueryString();
        } else {
            $tarefas = $this->repository->paginateByUser(auth()->id(), $status, 15)->withQueryString();
        }

        return view('pages.tarefas.index', [
            'tarefas' => $tarefas,
            'currentStatus' => $status,
            'excluidos' => $excluidos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tarefas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TarefaRequest $request)
    {
        $task = $this->repository->createForUser($request->all(), Auth::id());

        return redirect()->route('tarefas.edit', $task);
    }

    /**
     * Mark the task as completed.
     */
    public function concluir(Request $request, Tarefa $tarefa)
    {
        $this->repository->toggleStatus($tarefa);

        $status = $request->input('status');
        if (! empty($status)) {
            return redirect()->route('tarefas.index', ['status' => $status]);
        }

        return redirect()->route('tarefas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        return view('pages.tarefas.edit', ['tarefa' => $tarefa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TarefaRequest $request, Tarefa $tarefa)
    {
        $this->repository->update($tarefa, $request->all());

        return redirect()->route('tarefas.edit', $tarefa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        $this->repository->delete($tarefa);

        return redirect()->route('tarefas.index');
    }

    /**
     * Restore a soft-deleted tarefa.
     */
    public function restore($id)
    {
        $this->repository->restoreByIdForUser($id, auth()->id());

        return redirect()->route('tarefas.index');
    }
}
