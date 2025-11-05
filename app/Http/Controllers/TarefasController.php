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

        return redirect()->route('tarefas.edit', $task)->with('success', 'Tarefa criada com sucesso.');
    }

    /**
     * Mark the task as completed.
     */
    public function concluir(Request $request, Tarefa $tarefa)
    {
        $tarefa = $this->repository->toggleStatus($tarefa);

        $message = $tarefa->status === 'concluida' ? 'Tarefa marcada como concluída.' : 'Tarefa reaberta.';

        $status = $request->input('status');
        if (! empty($status)) {
            return redirect()->route('tarefas.index', ['status' => $status])->with('success', $message);
        }

        return redirect()->route('tarefas.index')->with('success', $message);
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
        return redirect()->route('tarefas.edit', $tarefa)->with('success', 'Tarefa atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        $this->repository->delete($tarefa);
        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso.');
    }

    /**
     * Restore a soft-deleted tarefa.
     */
    public function restore($id)
    {
        $restored = $this->repository->restoreByIdForUser($id, auth()->id());

        if ($restored) {
            return redirect()->route('tarefas.index')->with('success', 'Tarefa restaurada com sucesso.');
        }

        return redirect()->route('tarefas.index')->with('error', 'Tarefa não encontrada ou não pôde ser restaurada.');
    }
}
