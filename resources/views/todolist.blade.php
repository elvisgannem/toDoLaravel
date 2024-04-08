<x-app-layout xmlns:input="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col gap-5">
                    <x-input-error :messages="$errors->all()" class="text-center text-red-500 font-bold text-xl" />

                    @if(session('success'))
                        <div class="text-center text-green-500 font-bold text-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form class="flex flex-col items-center" action="{{ route('todolist.store') }}" method="POST">
                        @csrf
                        <label for="newTask"></label>
                        <input type="text" class="w-1/2 rounded" id="newTask" name="taskName" placeholder="Nome da tarefa" />
                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded w-1/2">Adicionar Tarefa</button>
                    </form>
                    <ul class="flex flex-col gap-4">

                        <form id="orderByForm" action={{ route('todolist.index') }} method="GET">
                            @csrf
                            <label for="orderBy">Ordenar por: </label>
                            <select name="orderBy" id="orderBy">
                                <option value="created_at" {{ $orderBy == 'created_at' ? 'selected' : '' }} >Data de criação</option>
                                <option value="name" {{ $orderBy == 'name' ? 'selected' : '' }} >Nome da tarefa</option>
                                <option value="finished" {{ $orderBy == 'finished' ? 'selected' : '' }} >Estado</option>
                            </select>
                        </form>

                        @foreach($tasks as $task)
                            <li class="flex justify-between flex-col md:flex-row">
                                <div class="flex gap-4 items-center w-1/2">
                                    <span class="h-4 w-4 rounded-full {{ $task->finished ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    <p>{{ $task->name }}</p>
                                </div>
                                <p id="relator">{{ $task->relator->name }}</p>
                                <form id="finishedForm" action="{{ route('todolist.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $task->id }}">
                                    @if ($task->finished)
                                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none text-sm" name="finished" id="finished" value="0">Marcar como não concluído</button>
                                    @else
                                        <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none" name="finished" id="finished" value="1">Marcar como concluído</button>
                                    @endif
                                </form>
                                <form action="{{ route('todolist.edit', $task->id) }}">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700 focus:outline-none">Editar</button>
                                </form>

                                <form action="{{ route('todolist.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">Apagar</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script>
        tippy('#relator', {
            content: 'Responsável da tarefa',
        });

        document.getElementById('orderByForm').addEventListener('change', function (event) {
            document.getElementById('orderByForm').submit();
        })
    </script>
</x-app-layout>
