<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarefaRequest;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $excluidos = $request->query('excluidos');

        if ($excluidos) {
            $query = Tarefa::onlyTrashed()->where('user_id', auth()->id());
        } else {
            $query = Tarefa::query()->where('user_id', auth()->id());

            if ($status) {
                $query->where('status', $status);
            }
        }

        $tarefas = $query->orderBy('id', 'asc')->paginate(15)->withQueryString();

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
        $task = Tarefa::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        return redirect()->route('tarefas.edit', $task);
    }

    /**
     * Mark the task as completed.
     */
    public function concluir(Request $request, Tarefa $tarefa)
    {
        $tarefa->status = $tarefa->status == 'pendente' ? 'concluida' : 'pendente';
        $tarefa->save();

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
        $tarefa->update($request->all());

        return redirect()->route('tarefas.edit', $tarefa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();

        return redirect()->route('tarefas.index');
    }

    /**
     * Restore a soft-deleted tarefa.
     */
    public function restore($id)
    {
        $tarefa = Tarefa::withTrashed()->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $tarefa->restore();

        return redirect()->route('tarefas.index');
    }
}
