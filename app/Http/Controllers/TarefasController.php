<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarefaRequest;
use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarefas = Tarefa::all()->sortBy('id', SORT_ASC);

        return view('pages.tarefas.index', ['tarefas' => $tarefas]);
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
        $data = $request->all();
        $data['concluida'] = $request->has('concluida') ? $request->boolean('concluida') : false;

        $task = Tarefa::create($data);

        return redirect()->route('tarefas.edit', $task);
    }

    /**
     * Mark the task as completed.
     */
    public function concluir(Tarefa $tarefa)
    {
        $tarefa->concluida = !$tarefa->concluida;
        $tarefa->save();

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
        $data = $request->all();
        $data['concluida'] = $request->has('concluida') ? $request->boolean('concluida') : false;

        $tarefa->update($data);

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
}
