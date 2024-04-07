<x-app-layout xmlns:input="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de tarefa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-input-error :messages="$errors->all()" class="text-center text-red-500 font-bold text-xl mt-6" />
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-5">
                    <div class="flex-1">
                        <ul class="flex justify-center gap-2 flex-wrap">
                            @foreach($users as $user)
                                <li class="w-full text-start md:text-center">
                                    {{ $user->name }}
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">Apagar</button>
                                </li>
                            @endforeach
                        </ul>
                        <form class="flex flex-col items-center" action="{{ route('todolist.addUsers', $task->id) }}">
                            @csrf
                            <button type="submit" class="mt-4 px-4 py-2 bg-yellow-700 text-white rounded w-full md:w-3/5">Adicionar usuários</button>
                        </form>
                    </div>
                    <form class="flex flex-col items-center gap-2 flex-1" action="{{ route('todolist.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $task->id }}">
                        <label for="taskName"></label>
                        <input type="text" class="w-full rounded" id="taskName" name="taskName" placeholder="Nome da tarefa" value="{{ $task->name }}" />
                        <label for="taskDescription"></label>
                        <input type="text" class="w-full rounded" id="taskDescription" name="taskDescription" placeholder="Descrição da tarefa" value="{{ $task->description }}" />
                        <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded w-full md:w-3/5">Atualizar Tarefa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
