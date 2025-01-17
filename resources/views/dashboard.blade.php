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
                            <li class="flex gap-2">
                                {{ $user->name }}
                                @if(!$user->isAdmin)
                                    <form action="{{ route('dashboard.makeAdmin', $user->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="text-green-500 hover:text-green-700 focus:outline-none">Tornar admin</button>
                                    </form>
                                @endif
                                <form action="{{ route('dashboard.deleteUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">Apagar</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
