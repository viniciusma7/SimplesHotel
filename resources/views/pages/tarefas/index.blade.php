<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tarefas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <h3 class="text-lg font-medium text-gray-900">Listagem de Tarefas</h3>
                        </div>

                        <div class="flex items-center space-x-4">
                            <form method="GET" action="{{ route('tarefas.index') }}" class="inline-flex items-center">
                                <label for="status" class="sr-only">Filtrar por status</label>
                                <select name="status" id="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="" {{ empty($currentStatus) ? 'selected' : '' }}>Todas</option>
                                    <option value="pendente" {{ ($currentStatus ?? request('status')) === 'pendente' ? 'selected' : '' }}>Pendentes</option>
                                    <option value="concluida" {{ ($currentStatus ?? request('status')) === 'concluida' ? 'selected' : '' }}>Concluídas</option>
                                </select>
                            </form>

                            <a href="{{ route('tarefas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cadastrar Tarefa
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criada em</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Concluida?</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tarefas as $tarefa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tarefa->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tarefa->titulo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ substr($tarefa->descricao, 0, 25) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tarefa->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($tarefa->status == 'concluida')
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Concluída</span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pendente</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="{{ route('tarefas.concluir', $tarefa) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $currentStatus ?? request('status') }}">
                                                <button
                                                    type="submit"
                                                    class="{{ $tarefa->status == 'pendente' ? 'text-green-600 hover:text-green-900'
                                                    : 'text-red-500 hover:text-red-900' }} mr-3">
                                                    {{ $tarefa->status == 'pendente' ? 'Concluir Tarefa' : 'Reabrir Tarefa' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('tarefas.edit', $tarefa) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                            <form action="{{ route('tarefas.destroy', $tarefa) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmar exclusão?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Nenhuma tarefa encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $tarefas->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
