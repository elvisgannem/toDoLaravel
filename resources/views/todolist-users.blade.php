<x-app-layout xmlns:input="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários da task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col gap-4">
                    @if(session('success'))
                        <div class="text-center text-green-500 font-bold text-xl">
                            {{ session('success') }}
                        </div>
                    @endif
                    <ul class="flex flex-wrap">
                        @foreach($users as $user)
                            <li class="w-full md:w-1/2 lg:w-1/4">
                                <form class="inline-block" action="{{ route('todolist.addUserToTask') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                        {{ $user->name }}
                                        <input type="hidden" name="task_id" value="{{ $taskId }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none font-bold text-2xl">+</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
