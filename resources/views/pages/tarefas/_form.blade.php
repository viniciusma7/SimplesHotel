@csrf
<div class="space-y-6">
    <div>
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $tarefa->titulo ?? '') }}"
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

    <div>
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="concluida" value="1" class="sr-only peer" @checked(old('concluida', $tarefa->concluida ?? false))>
            <div
                class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4
                peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white
                after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-900">Concluído?</span>
        </label>
        @error('concluida')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ isset($tarefa) ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </div>
