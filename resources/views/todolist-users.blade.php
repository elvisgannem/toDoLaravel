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
                    <ul class="flex flex-wrap">
                        @foreach($users as $user)
                            <li class="w-full md:w-1/2 lg:w-1/4">
                                <input type="checkbox" name="" id="">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <button type="submit" class="mt-4 px-4 py-2 bg-yellow-700 text-white rounded w-full">Adicionar usuários</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
