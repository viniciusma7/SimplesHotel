@csrf
<div class="space-y-6">
    <div>
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
        <input type="text" name="titulo" id="titulo"
            value="{{ old('titulo', $tarefa->titulo ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('titulo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
        <textarea name="descricao" id="descricao" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descricao', $tarefa->descricao ?? '') }}</textarea>
        @error('descricao')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ isset($tarefa) ? 'Atualizar' : 'Salvar' }}
        </button>
    </div>
</div>
