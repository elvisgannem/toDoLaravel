<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul>
                        @foreach($users as $user)
                            <li>
                                {{ $user->name }}
                                <form>
                                    <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none">Tornar admin</button>
                                </form>
                                <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">Apagar</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
